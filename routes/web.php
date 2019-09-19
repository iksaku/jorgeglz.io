<?php

//Route::prefix('/admin')->prefix(function () {
//  TODO
//});

Route::get('/', 'AppController@home')->name('home');
Route::get('about', 'AppController@about')->name('about');

Route::prefix('posts')->group(function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('who-am-i.html', function () {
        return redirect()->route('post', [
            'slug' => 'who-am-i',
        ], 301);
    });

    Route::get('{slug}', 'AppController@post')->name('post');
});

Route::get('{any}', function () {
    return inertia('App/Error', [
        'code' => 404,
        'message' => 'Well, it looks like you reached nowhere...',
    ]);
})->where('any', '.*');
