<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'confirm' => true, // Password Confirmation
    'register' => false, // Registration
    'reset' => false, // Password Reset
    'verify' => false, // Email Verification
]);

Route::name('blog.')->group(function () {
    Route::get('/', 'Blog\IndexController@index')->name('index');
    Route::get('about', function () {
        $phrases = [
            "Still don't know me?",
            "Haven't we already met?",
            'So, you want to know more about me...',
            'This is me... '.emoji('notes'),
            'Who am I you ask?',
            'Peeking at my blog without knowing me?',
            '¿Sabías que hablo Español? '.emoji('mexico'),
        ];

        return view('blog.about', [
            'introductoryPhrase' => $phrases[array_rand($phrases, 1)],
        ]);
    })->name('about');

    Route::prefix('posts')->group(function () {
        Route::get('/', 'Blog\PostController@index');
        Route::get('{post}', 'Blog\PostController@show')->name('post');
    });
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
