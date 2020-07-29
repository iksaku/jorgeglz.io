<?php

namespace App\Providers;

use Github\Client;
use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('github', function () {
            $client = new Client();

            if (!empty(config('social.github.token'))) {
                $client->authenticate(config('social.github.token'), Client::AUTH_ACCESS_TOKEN);
            }

            return $client;
        });

        $this->app->alias('github', Client::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
