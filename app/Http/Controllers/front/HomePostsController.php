<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePostsController extends Controller
{
    public function homeposts()
    {
        $recentPosts = Post::orderBy('created_at', 'desc')->take(3)->get();
        return view('front.partial.home', compact('recentPosts'));
    }
}
