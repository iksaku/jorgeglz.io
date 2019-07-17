<?php

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'WebController@dashboard')->name('dashboard');
    Route::get('/{any}', 'WebController@dashboard')->where('any', '.*');
});

Route::get('/{any}', 'WebController@app')->where('any', '.*');
