<?php

Auth::routes([
    'confirm' => true,
    'register' => false,
    'reset' => true,
    'verify' => true,
]);

Route::get('/', 'Blog\IndexController@index')->name('blog.index');
Route::get('about', 'Blog\AboutController@index')->name('blog.about');
Route::prefix('posts')->group(function () {
    Route::get('/', 'Blog\PostController@index');
    Route::get('{post}', 'Blog\PostController@show')->name('blog.post');
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Dashboard\IndexController@index')->name('index');

    Route::resource('posts', 'Dashboard\PostController');
    Route::patch('posts/{trashed_post}/restore', 'Dashboard\PostController@restore')
        ->name('posts.restore');

    Route::fallback(function () {
        abort(404, 'Well, it looks like you reached nowhere...');
    })->name('error')->where('any', '.*');
});

Route::fallback(function () {
    abort(404, 'Well, it looks like you reached nowhere...');
})->name('blog.error');
