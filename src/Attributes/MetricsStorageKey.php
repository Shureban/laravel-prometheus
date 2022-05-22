<?php

namespace Shureban\LaravelPrometheus\Attributes;

use Stringable;
use Shureban\LaravelPrometheus\Enums\MetricType;

class MetricsStorageKey implements Stringable
{
    private string     $prefix;
    private MetricType $type;
    private Name       $name;

    /**
     * @param Name       $name
     * @param MetricType $type
     */
    public function __construct(Name $name, MetricType $type)
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
        return implode(':', [$this->prefix, $this->type->value, $this->name]);
    }
}
