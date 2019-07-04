<?php

Route::prefix('v1')->group(function() {
    Route::apiResource('posts', 'v1\PostController');

    Route::apiResource('tags', 'v1\TagController');
});