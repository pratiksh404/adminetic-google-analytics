<?php

namespace Adminetic\GoogleAnalytics;

use Adminetic\GoogleAnalytics\Http\Livewire\GoogleAnalytics;
use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;

class GoogleAnalyticsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishResource();
        }
        // Register Resources
        $this->registerResource();
        // Register View Components
        $this->registerLivewireComponents();
    }

    /**
     * Publish Package Resource.
     *
     *@return void
     */
    protected function publishResource()
    {
        // Publish Config File
        $this->publishes([
            __DIR__ . '/../../config/adminetic-google-analytic.php' => config_path('adminetic-google-analytic.php'),
        ], 'notify-config');
    }

    /**
     * Register Package Resource.
     *
     *@return void
     */
    protected function registerResource()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'google_analytic'); // Loading Views Files
    }



    /**
     * Register Components.
     *
     *@return void
     */
    protected function registerLivewireComponents()
    {
        Livewire::component('adminetic.google-analytics', GoogleAnalytics::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/adminetic-google-analytic.php', 'adminetic-google-analytic');
    }
}
