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

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'Dashboard\IndexController@index')->name('dashboard.index');
});

Route::get('{any}', function () {
    abort(404, 'Well, it looks like you reached nowhere...');
})->where('any', '.*');
