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
     * @param MetricType $type
     * @param MetricName $name
     */
    public function __construct(MetricType $type, MetricName $name)
    {
        $this->type   = $type;
        $this->name   = $name;
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
