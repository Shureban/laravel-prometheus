<?php

namespace Shureban\LaravelPrometheus\Prometheus\Attributes;

use Stringable;
use Shureban\LaravelPrometheus\Prometheus\Enums\MetricType;

class CounterMetricsStorageName implements Stringable
{
    private string $prefix;

    public function __construct()
    {
        $this->prefix = config('prometheus.metric_prefix');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return implode('_', [$this->prefix, MetricType::Counter(), 'METRIC_KEYS']);
    }
}
