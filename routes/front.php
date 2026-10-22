<?php

use App\Http\Controllers\front\BlogPostsController;
use App\Http\Controllers\front\HomePostsController;
use App\Http\Controllers\front\SubscriberController;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', [HomePostsController::class, 'homeposts'])->name('home');
Route::get('front/blog', [BlogPostsController::class, 'categoryposts'])->name('front.blog');
Route::get('post/filter', [BlogPostsController::class, 'filtercategory'])->name('post.filter');
Route::post('posts/{post}/like', [BlogPostsController::class, 'toggleLike'])->name('post.like');
Route::post('posts/{post}/comments', [BlogPostsController::class, 'comment'])->name('comments.store');
Route::get('blog/{id}', [BlogPostsController::class, 'show'])->name('blog.show');

Route::get('front/contactus', function () {
    return view('front.partial.contact_us');
})->name('front.contactus');

// Subscriber Routes
Route::get('unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');
Route::post('contact/subscriber', [SubscriberController::class, 'subscribe'])->name('contact.subscriber');
