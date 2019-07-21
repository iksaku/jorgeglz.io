<?php

Route::prefix('dashboard')->group(function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/', 'WebController@dashboard')->name('dashboard');
    Route::get('{any}', 'WebController@dashboard')->where('any', '.*');
});

Route::get('{any}', 'WebController@app')->where('any', '^(?!dashboard).*');
