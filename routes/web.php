<?php

//Route::prefix('/admin')->prefix(function () {
//  TODO
//});

Route::get('/', 'Blog\IndexController@index')->name('blog.index');
Route::get('about', 'Blog\AboutController@index')->name('blog.about');
Route::prefix('posts')->group(function () {
    Route::get('/', 'Blog\PostController@index');
    Route::get('{post}', 'Blog\PostController@show')->name('blog.post');
});

Route::get('{any}', function () {
    return view('blog.error', [
        'code' => 404,
        'message' => 'Well, it looks like you reached nowhere...',
    ]);
})->where('any', '.*');

/*Route::prefix('posts')->group(function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('who-am-i.html', function () {
        return redirect()->route('post', [
            'slug' => 'who-am-i',
        ], 301);
    });

    Route::get('{slug}', 'AppController@post')->name('blog.post');
});*/

/*Route::get('{any}', function () {
    return inertia('App/Error', [
        'code' => 404,
        'message' => 'Well, it looks like you reached nowhere...',
    ]);
})->where('any', '.*');*/
