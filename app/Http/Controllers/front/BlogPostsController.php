<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment as ModelsComment;
use App\Models\Post;
use App\Models\Post_likes;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BlogPostsController extends Controller
{
    public function categoryposts()
    {
        $categories = Category::all();
        $tags = Tag::withCount('posts')->get();

        $perPage = (int) (\App\Models\Setting::where('key', 'posts_per_page')->value('value') ?? 10);
        $posts = Post::with(['tags', 'category'])->latest()->take($perPage)->get();

        return view('front.partial.blog', compact('categories', 'tags', 'posts'));
    }

    public function filtercategory(Request $request)
    {
        $categoryId = $request->query('category_id');
        $tagId = $request->query('tag_id');

        $query = Post::with(['tags', 'category'])->latest();

        if ($categoryId && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        if ($tagId && $tagId !== 'all') {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        $perPage = (int) (\App\Models\Setting::where('key', 'posts_per_page')->value('value') ?? 10);
        $posts = $query->take($perPage)->get();

        return view('front.partial.post_list', compact('posts'));
    }
    public function toggleLike(Request $request, Post $post): JsonResponse
    {
        $identifierHash = hash('sha256', $request->ip() . '|' . $request->userAgent());

        $result = DB::transaction(function () use ($post, $identifierHash) {

            $existingLike = Post_likes::where('post_id', $post->id)

                ->where('identifier_hash', $identifierHash)
                ->first();

            if ($existingLike) {
                $existingLike->delete();
                $post->decrement('likes_count');
                $liked = false;
            } else {
                Post_likes::create([
                    'post_id' => $post->id,
                    'identifier_hash' => $identifierHash,
                ]);
                $post->increment('likes_count');
                $liked = true;
            }

            return [
                'liked' => $liked,
                'likes_count' => $post->fresh()->likes_count,
            ];
        });

        return response()->json([
            'status' => 'success',
            'liked' => $result['liked'],
            'likes_count' => $result['likes_count'],
        ]);
    }
    public function comment(Request $request, Post $post)
    {
        // Check if comments are allowed in settings
        $allowComments = \App\Models\Setting::where('key', 'allow_comments')->value('value');
        if ($allowComments !== null && (string)$allowComments === '0') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Comments are currently disabled by the administrator.'
            ], 403);
        }

        // 1. Validation
        $validated = $request->validate([
            'comment_body' => 'required|string|max:1000',
            'name'         => 'nullable|string|max:100',
            'email'        => 'nullable|email|max:255',
        ]);

        $comment = Comment::create([
            'post_id'      => $post->id,
            'name'         => !empty($validated['name']) ? $validated['name'] : 'Guest',
            'email'        => $validated['email'] ?? null,
            'comment_body' => $validated['comment_body'],
            'status'       => 'approved',
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
        ]);

        $comments = Comment::where('post_id', $post->id)
            ->where('status', 'approved')
            ->latest()->get();

        return response()->json([
            'status'         => 'success',
            'message'        => 'Comment added successfully!',
            'comments_count' => $comments->count(),
            'comment'        => [
                'name'         => $comment->name,
                'comment_body' => $comment->comment_body,
                'time_ago'     => $comment->created_at->diffForHumans(),
            ]
        ], 201);
    }
    public function show($id)
    {
        $categories = Category::all();
        $post = Post::findOrFail($id);
        $viewed_key = 'viewed_post_' . $post->id;
        if (!session()->has($viewed_key)) {
            $post->increment('views_count');
            session()->put($viewed_key, true);
        }
        $posts = collect([$post]);
        return view('front.partial.post_list', compact('categories', 'posts'));
    }
}
