<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Storage Adapter
    |--------------------------------------------------------------------------
    |
    | The storage adapter to use.
    |
    | Supported: "Prometheus\Storage\Adapter"
    |
    */

    'storage_adapter_class' => \Shureban\LaravelPrometheus\Storage\Predis::class,

    /*
    |--------------------------------------------------------------------------
    | Namespace
    |--------------------------------------------------------------------------
    |
    | The namespace to use as a prefix for all metrics.
    |
    | This will typically be the name of your project.
    |
    */
    'project_namespace'     => '',
    'metric_prefix'         => 'PROMETHEUS',
];
