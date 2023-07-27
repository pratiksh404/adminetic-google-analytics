<?php

namespace Adminetic\GoogleAnalytics\Provider;

use Adminetic\GoogleAnalytics\Http\Livewire\GoogleAnalytics;
use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;

class GoogleAnalyticsServiceProvider extends ServiceProvider
{
    public function boot()
    {

        // Register Resources
        $this->registerResource();
        // Register View Components
        $this->registerLivewireComponents();
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
        //
    }
}
