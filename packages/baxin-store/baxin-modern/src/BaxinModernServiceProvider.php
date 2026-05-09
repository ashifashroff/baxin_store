<?php

namespace BaxinStore\BaxinModern;

use BaxinStore\BaxinModern\Http\ViewComposers\HomeComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class BaxinModernServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'baxin-modern');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/baxin-modern/assets'),
        ], 'public');

        // Register HomeComposer for both namespace variants
        View::composer('baxin-modern::home.index', HomeComposer::class);
        View::composer('shop::home.index', HomeComposer::class);
    }

    public function register(): void
    {
        //
    }
}
