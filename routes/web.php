<?php

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::get('/{any}', function() {
    return view('index');
})->where('any', '.*');