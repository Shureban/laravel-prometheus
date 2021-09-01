<?php

namespace Shureban\LaravelPrometheus;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Shureban\LaravelPrometheus\Storage\Predis;
use Shureban\LaravelPrometheus\Commands\GaugeMakeCommand;
use Shureban\LaravelPrometheus\Commands\CounterMakeCommand;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Predis::class, fn (Application $app) => new Predis());
        $this->commands([
            CounterMakeCommand::class,
            GaugeMakeCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config' => base_path('config')]);
    }
}
