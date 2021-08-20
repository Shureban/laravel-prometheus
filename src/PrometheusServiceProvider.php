<?php

namespace Shureban\LaravelPrometheus;

use Illuminate\Support\ServiceProvider;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config' => config_path('prometheus.php')]);
    }
}
