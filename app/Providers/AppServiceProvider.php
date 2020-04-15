<?php

namespace App\Providers;

use App\Observers\PostCacheObserver;
use App\Post;
use Illuminate\Pagination\Paginator;
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
        Paginator::defaultView('pagination::tailwind');

        Post::observe(PostCacheObserver::class);
    }
}
