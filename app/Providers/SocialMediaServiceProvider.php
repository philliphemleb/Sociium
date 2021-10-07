<?php

namespace App\Providers;

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
        $this->app->singleton(TwitterService::class);
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
