<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

// Public pages: can be seen by guests
Route::get('/', [PostController::class, 'index'])
    ->name('dashboard');
Route::get('/search', [PostController::class, 'search'])
    ->name('post.search');
Route::get('/category/{category}', [PostController::class, 'category'])
    ->name('post.byCategory');
Route::get('/@{user:username}', [PublicProfileController::class, 'show'])
    ->name('profile.show');
Route::get('/@{user:username}/{post:slug}', [PostController::class, 'show'])
    ->name('post.show');

// Write operations: login and confirmed email required
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/post/create', [PostController::class, 'create'])
        ->name('post.create');
    Route::post('/post/create', [PostController::class, 'store'])
        ->name('post.store');
    Route::get('/post/{post:slug}/edit', [PostController::class, 'edit'])
        ->name('post.edit');
    Route::put('/post/{post:slug}', [PostController::class, 'update'])
        ->name('post.update');
    Route::delete('/post/{post:slug}', [PostController::class, 'destroy'])
        ->name('post.destroy');
    Route::post('/@{user:username}/follow', [FollowController::class, 'store'])
        ->name('follow.store');
    Route::delete('/@{user:username}/follow', [FollowController::class, 'destroy'])
        ->name('follow.destroy');
    Route::post('/post/{post}/like', [LikeController::class, 'store'])
        ->name('like.store');
    Route::delete('/post/{post}/like', [LikeController::class, 'destroy'])
        ->name('like.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
