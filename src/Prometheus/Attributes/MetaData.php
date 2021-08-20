<?php

namespace Shureban\LaravelPrometheus\Prometheus\Attributes;

use JsonSerializable;
use Shureban\LaravelPrometheus\Prometheus\Enums\MetricType;

class MetaData implements JsonSerializable
{
    private MetricName       $name;
    private string           $help;
    private MetricType       $type;
    private MetricLabelsList $labels;

    public function __construct(MetricName $name, string $help, MetricType $type, MetricLabelsList $labels)
    {
        $this->name   = $name;
        $this->help   = $help;
        $this->type   = $type;
        $this->labels = $labels;
    }

    public function jsonSerialize(): array
    {
        return [
            'name'       => $this->name,
            'help'       => $this->help,
            'type'       => (string)$this->type,
            'labelNames' => $this->labels,
        ];
    }
}
