<?php

namespace Shureban\LaravelPrometheus;

use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Shureban\LaravelPrometheus\Commands\CounterMakeCommand;
use Shureban\LaravelPrometheus\Commands\GaugeMakeCommand;
use Shureban\LaravelPrometheus\Storage\Predis;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Predis::class, fn(Application $app) => new Predis());
        $this->commands([
            CounterMakeCommand::class,
            GaugeMakeCommand::class,
        ]);

        if (config('prometheus.web_route')) {
            Route::get(config('prometheus.web_route'), fn() => response(new RenderTextFormat(), Response::HTTP_OK, ['Content-Type' => RenderTextFormat::MIME_TYPE]));
        }
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
