<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();
        $totalPosts = Post::count();
        $recentPosts = Post::orderBy('created_at', 'desc')->take(10)->get();
        $recentComments = Comment::orderBy('created_at', 'desc')->take(10)->get();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();

        return view('admin.partial.dashboard', compact(
            'categories',
            'totalPosts',
            'publishedPosts',
            'recentPosts',
            'recentComments',
            'draftPosts'
        ));
    }
}
