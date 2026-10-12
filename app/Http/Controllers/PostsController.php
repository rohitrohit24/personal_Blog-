<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;

class PostsController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.partial.posts', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'content' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $post = new Post();
        $post->user_id = Auth::id() ?? 1;
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->content = $request->content;
        $post->image = $request->image;
        $post->status = $request->status;
        $post->save();

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        // Sirf published post hone par subscribers ko mail bhejein
        if ($post->status === 'published') {
            $subscribers = Subscribers::where('is_active', 1)->pluck('email')->toArray();

            if (!empty($subscribers)) {
                foreach ($subscribers as $email) {
                    Mail::to(trim($email))->queue(new SendEmail($post));
                }
            }
        }

        return redirect()->back()->with('success', 'Post created successfully');
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($post->id)],
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:draft,published',
            'content'     => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id'
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        } else {
            unset($validated['image']);
        }

        $post->update($validated);
        $post->tags()->sync($request->tags ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data'    => $post
        ], 200);
    }
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
    //         'category_id' => 'required|exists:categories,id',
    //         'status' => 'required|in:draft,published',
    //         'content' => 'required'
    //     ]);


    //     $post = Post::findOrFail($id);
    //     $post->category_id = $request->category_id;
    //     $post->title = $request->title;
    //     $post->slug = $request->slug;
    //     $post->content = $request->content;
    //     $post->image = $request->image;
    //     $post->status = $request->status;
    //     $post->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Post updated successfully'
    //     ]);
    // }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ]);
    }
}
