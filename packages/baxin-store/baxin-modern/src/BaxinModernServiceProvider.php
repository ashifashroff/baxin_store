<?php

namespace BaxinStore\BaxinModern;

use Illuminate\Support\ServiceProvider;

class BaxinModernServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'baxin-modern');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/baxin-modern/assets'),
        ], 'public');
    }

    public function register(): void
    {
        //
    }
}
