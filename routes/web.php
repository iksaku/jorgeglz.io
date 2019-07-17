<?php

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::prefix('dashboard')->middleware('auth')->group(function() {
    Route::get('/', function() {
        return view('dashboard');
    });

    Route::get('/{any}', function() {
        return view('dashboard');
    })->where('any', '.*');
});

Route::get('/{any}', function() {
    return view('index');
})->where('any', '.*');