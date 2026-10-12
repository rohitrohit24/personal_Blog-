<?php

use App\Http\Controllers\front\BlogPostsController;
use App\Http\Controllers\front\ContactUsController;
use App\Http\Controllers\front\HomePostsController;
use Illuminate\Support\Facades\Route;

// Aapke public frontend routes yahan aayenge
// Route::get('front/home', function () {
//     return view('front.partial.home');
// })->name('home');
// Route::get('/', function () {
//     return view('front.partial.home');
// })->name('home');
Route::get('/', [HomePostsController::class, 'homeposts'])->name('home');
Route::get('front/blog', [BlogPostsController::class, 'categoryposts'])->name('front.blog');
Route::get('post/filter', [BlogPostsController::class, 'filtercategory'])->name('post.filter');
Route::post('posts/{post}/like', [BlogPostsController::class, 'toggleLike'])->name('post.like');
Route::post('contact/subscriber', [ContactUsController::class, 'subscriber'])->name('contact.subscriber');
Route::get('unsubscribe/{token}', [ContactUsController::class, 'unsubscribe'])->name('unsubscribe');
Route::post('posts/{post}/comments', [BlogPostsController::class, 'comment'])->name('comments.store');
Route::get('blog/{id}', [BlogPostsController::class, 'show'])->name('blog.show');

// Route::get('front/contactus', [ContactUsController::class, ''])->name('front.blog');
Route::get('front/contactus', function () {
    return view('front.partial.contact_us');
})->name('front.contactus');

Route::get('view/layout', [HomePostsController::class, 'userview'])->name('view.layout');
