<?php

use App\Actions\Auth\Login;
use App\Actions\Auth\Password\Confirm;
use App\Actions\Blog\About;
use App\Actions\Blog\Index as BlogIndex;
use App\Actions\Blog\PostView;
use App\Actions\Dashboard\Index as DashboardIndex;
use App\Actions\Dashboard\Posts\Index as DashboardPostsIndex;

Route::name('auth.')->group(function () {
    Route::get('login', Login::class)->name('login');

    Route::get('password/confirm', Confirm::class)->name('password.confirm');
});

Route::name('blog.')->group(function () {
    Route::get('/', BlogIndex::class)->name('index');

    Route::get('about', About::class)->name('about');

    Route::prefix('posts')->group(function () {
        Route::get('/', BlogIndex::class);

        Route::get('{post}', PostView::class)->name('post');
    });
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
    Route::get('/', DashboardIndex::class)->name('index');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', DashboardPostsIndex::class)->name('index');

        // TODO: View

        // TODO: Create

        // TODO: Edit
    });
//    Route::patch('posts/{trashed_post}/restore', 'Dashboard\PostController@restore')
//        ->name('posts.restore');
//
//    Route::fallback(function () {
//        abort(404, 'Well, it looks like you reached nowhere...');
//    })->name('error')->where('any', '.*');
});

//Route::fallback(function () {
//    abort(404, 'Well, it looks like you reached nowhere...');
//})->name('blog.error');
