<?php

namespace BaxinStore\BaxinModern;

use BaxinStore\BaxinModern\Http\ViewComposers\HomeComposer;
use Illuminate\Support\ServiceProvider;

class BaxinModernServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'baxin-modern');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/baxin-modern/assets'),
        ], 'public');

        view()->composer('baxin-modern::home.index', HomeComposer::class);
        view()->composer('shop::home.index', HomeComposer::class);
    }

    public function register(): void
    {
        //
    }
}
