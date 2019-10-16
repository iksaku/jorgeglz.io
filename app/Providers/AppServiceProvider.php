<?php

namespace App\Providers;

use App\Observers\PostCacheObserver;
use App\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
//        Validator::extend('tag_list', 'App\Rules\TagList@passes', 'The :attribute must be a comma-separated list');
        Post::observe(PostCacheObserver::class);
    }
}
