<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SaveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\PostApiController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// OAuth Routes - Place OUTSIDE the auth middleware
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::get('/auth/github', [GithubController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback', [GithubController::class, 'callback']);

// Admin-only routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    // More admin routes...
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Post Moderation
    Route::get('/posts', [AdminUserController::class, 'index'])->name('admin.posts');
    Route::put('/posts/{post}/approve', [AdminUserController::class, 'approve'])->name('admin.posts.approve');
    Route::put('/posts/{post}/reject', [AdminUserController::class, 'reject'])->name('admin.posts.reject');
    
    // Statistics
    Route::get('/stats', [AdminUserController::class, 'index'])->name('admin.stats');
});

// Editor+Admin routes
Route::middleware(['auth', 'editor'])->group(function () {
    Route::resource('posts', PostController::class)->except(['show']);
});

Route::middleware(['auth', 'editor'])->group(function () {
    Route::resource('posts', PostController::class)->except(['show']);
});

// Comments
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
     ->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
     ->name('comments.destroy');

// AJAX
Route::post('/posts/{post}/like', LikeController::class)->name('posts.like');
Route::post('/posts/{post}/save', SaveController::class)->name('posts.save');

// Public routes
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostApiController::class);
    Route::post('posts/{post}/like', [LikeController::class, '__invoke']);
    Route::get('/user', fn (Request $request) => $request->user());
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';