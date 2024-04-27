<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group([
    'middleware' => 'auth',
], function () {

    Route::controller(EmailVerificationController::class)->as('verification.')->group(function () {
        Route::get('/email/verify', 'notice')->name('notice');

        Route::post('/email/verification-notification', 'resend')->middleware('throttle:6,1')->name('resend');

        Route::get('/email/verify/{id}/{hash}', 'verify')->middleware('signed')->name('verify');
    });

    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');

    Route::post('/comment', [CommentController::class, 'store'])->name('comment.add');
    Route::post('/comment/reply/{comment}', [CommentController::class, 'replyStore'])->name('reply.add');

    Route::post('/delete/comment/{comment}', [CommentController::class, 'deleteComment'])->name('delete.comment');

    Route::group([
        'middleware' => 'verified',
    ], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');;
    });
});

Route::get('/post', [PostController::class, 'index'])->name('post.index');
Route::get('/post/show/{post}', [PostController::class, 'show'])->name('post.show');
