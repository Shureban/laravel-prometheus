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

    'storage_adapter_class' => Shureban\LaravelPrometheus\Storage\Predis::class,

    /*
    |--------------------------------------------------------------------------
    | Project namespace
    |--------------------------------------------------------------------------
    |
    | The namespace to use as a prefix for all metrics.
    |
    | This will typically be the name of your project.
    |
    | Helping to split metrics for different projects.
    |
    */

    'project_namespace' => '',

    /*
    |--------------------------------------------------------------------------
    | Metric prefix
    |--------------------------------------------------------------------------
    |
    | This prefix adding to all metrics key in next storages: predis
    |
    | Help with finding all metrics keys
    |
    */

    'metric_prefix' => 'PROMETHEUS',
];
