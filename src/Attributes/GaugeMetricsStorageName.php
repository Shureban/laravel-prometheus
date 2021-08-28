<?php

namespace Shureban\LaravelPrometheus\Attributes;

use Stringable;
use Shureban\LaravelPrometheus\Enums\MetricType;

class GaugeMetricsStorageName implements Stringable
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
        return implode('_', [$this->prefix, MetricType::Gauge(), 'METRIC_KEYS']);
    }
}
