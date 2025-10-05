<?php

namespace ShufflingPixels\Toast;

use Illuminate\Support\ServiceProvider;

class ToastServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Manager::class, function ($app) {
            return new Manager($app['session.store']);
        });

        $this->app->alias(Manager::class, 'shufflingpixels.toast');
    }
}
