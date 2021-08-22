<?php

namespace Shureban\LaravelPrometheus\Prometheus\Attributes;

use Stringable;
use Shureban\LaravelPrometheus\Prometheus\Enums\MetricType;

class MetricKey implements Stringable
{
    private string     $prefix;
    private MetricType $type;
    private MetricName $name;

    /**
     * @param MetricName $name
     * @param MetricType $type
     */
    public function __construct(MetricName $name, MetricType $type)
    {
        $this->name   = $name;
        $this->type   = $type;
        $this->prefix = config('prometheus.metric_prefix');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return implode(':', [$this->prefix, $this->type, $this->name]);
    }
}
