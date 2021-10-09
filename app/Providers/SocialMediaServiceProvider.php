<?php

namespace App\Providers;

use App\Factories\TwitterOAuthFactory;
use App\Http\Services\TwitterService;
use Illuminate\Support\ServiceProvider;

class SocialMediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TwitterService::class, function($app) {
            return new TwitterService($app->get(TwitterOAuthFactory::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
