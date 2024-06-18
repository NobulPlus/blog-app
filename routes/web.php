<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
Route::get('/posts', 'App\Http\Controllers\PostController@index')->name('posts.index'); 

    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/posts/create', 'App\Http\Controllers\PostController@create')->name('create.post');
});

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts', 'App\Http\Controllers\PostController@store')->name('posts.store'); 
Route::get('/posts/{post}/edit', 'App\Http\Controllers\PostController@edit')->name('posts.edit');
Route::put('/posts/{post}/edit', 'App\Http\Controllers\PostController@update')->name('posts.update');
Route::delete('/posts/{post}/edit', 'App\Http\Controllers\PostController@destroy')->name('posts.destroy');

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', 'App\Http\Controllers\CommentController@store')->name('comments.store');
    Route::delete('/comments/{comment}', 'App\Http\Controllers\CommentController@destroy')->name('comments.destroy');
});





require __DIR__.'/auth.php';
