<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Storage Adapter
    |--------------------------------------------------------------------------
    |
    | Common storage for all metrics
    |
    | For any metric you can change storage, rewrites getStorage method
    |
    */

    'storage_adapter_class' => Shureban\LaravelPrometheus\Storage\Predis::class,

    /*
    |--------------------------------------------------------------------------
    | Common storage folder
    |--------------------------------------------------------------------------
    |
    | Folder, where stored all metrics
    |
    | Used in make:metrics command
    |
    */

    'storage_path' => 'App\Prometheus',

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

    /*
    |--------------------------------------------------------------------------
    | Web route
    |--------------------------------------------------------------------------
    |
    | Attach route for your web application
    |
    | From this path you can get metrics data
    |
    | If you want to add custom route, or disable this route, set null
    |
    */

    'web_route' => '/prometheus/metrics',
];
