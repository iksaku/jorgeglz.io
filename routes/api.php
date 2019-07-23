<?php

Route::prefix('v1')->group(function () {
    Route::apiResource('posts', 'v1\PostController', [
        'only' => ['index', 'show'],
    ]);

    Route::apiResource('tags', 'v1\TagController', [
        'only' => ['index', 'show'],
    ]);
});
