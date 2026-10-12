<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagsController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__ . '/auth.php';


Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('login', function () {
        return view('admin.auth.login');
    })->name('admin.login');

    Route::post('auth', [LoginController::class, 'login'])->name('admin.auth');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Route::view('dashboard', 'dashboard')
    //     ->middleware('verified')
    //     ->name('dashboard');

    // Admin Panel Group
    Route::prefix('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Profile & Logout Routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/logout', [ProfileController::class, 'logout'])->name('admin.profile.logout');

        // Settings View
        Route::get('/settings', function () {
            return view('admin.partial.settings');
        })->name('admin.settings');

        // Categories View (Partial/AJAX)
        // Route::get('/categories/view', function () {
        //     return view('admin.partial.categories');
        // })->name('categories.in');
    });

    // Settings (Volt Components)
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Resource: Categories
    Route::prefix('categories')->controller(CategoriesController::class)->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
    });

    // Resource: Posts
    Route::prefix('posts')->controller(PostsController::class)->name('posts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
    });

    // Resource: Tags
    Route::prefix('tags')->controller(TagsController::class)->name('tags.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
    });

    // Resource: Comments
    Route::prefix('comments')->controller(CommentsController::class)->name('comments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
        Route::post('approve/{id}', 'approve')->name('approve');
        Route::post('reject/{id}', 'reject')->name('reject');
    });
});
