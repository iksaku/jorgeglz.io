<?php

/*Route::get('{any}', function () {
    return view('index');
})->where('any', '^(?!nova).*');*/

Route::get('/', 'AppController@home')->name('home');
Route::get('about', 'AppController@about')->name('about');

Route::prefix('posts')->group(function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('who-am-i.html', function () {
        return redirect()->route('posts', [
            'slug' => 'who-am-i',
        ], 302);
    });

    Route::get('{slug}', 'AppController@post');
});

Route::get('{any}', function () {
    return inertia('App/Error', [
        'code' => 404,
        'message' => 'Well, it looks like you reached nowhere...',
    ]);
})->where('any', '.*');
