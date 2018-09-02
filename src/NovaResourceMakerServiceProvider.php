<?php
namespace Inani\NovaResourceMaker;

use Illuminate\Support\ServiceProvider;
use Inani\NovaResourceMaker\Commands\MakeNovaResource;

class NovaResourceMakerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot What is needed
     *
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeNovaResource::class,
            ]);
        }
    }
}