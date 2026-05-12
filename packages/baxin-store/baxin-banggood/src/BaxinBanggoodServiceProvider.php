<?php

namespace BaxinStore\BaxinBanggood;

use BaxinStore\BaxinBanggood\Http\ViewComposers\HomeComposer;
use Illuminate\Support\ServiceProvider;

class BaxinBanggoodServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'baxin-banggood');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/baxin-banggood/assets'),
        ], 'public');

        // Composers
        view()->composer('baxin-banggood::home.index', HomeComposer::class);
        view()->composer('shop::home.index', HomeComposer::class);
    }

    public function register(): void
    {
        //
    }
}
