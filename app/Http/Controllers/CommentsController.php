<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.partial.comments', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment_body' => 'required',
            'status' => 'required|in:pending,approved,spam'
        ]);

        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment_body = $request->comment_body;
        $comment->status = $request->status;

        $comment->save();
        return redirect()->back()->with('success', 'Comment created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment_body' => 'required',
            'status' => 'required|in:pending,approved,spam'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->post_id = $request->post_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment_body = $request->comment_body;
        $comment->status = $request->status;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment deleted successfully'
        ]);
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 'approved';
        $comment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment approved successfully'
        ]);
    }

    public function reject($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 'spam';
        $comment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment rejected successfully'
        ]);
    }
}
