<?php

namespace Shureban\LaravelPrometheus\Attributes;

use JsonSerializable;
use Shureban\LaravelPrometheus\Enums\MetricType;

class MetaData implements JsonSerializable
{
    private MetricName       $name;
    private string           $help;
    private MetricType       $type;
    private MetricLabelsList $labels;

    /**
     * @param MetricName       $name
     * @param MetricType       $type
     * @param string           $help
     * @param MetricLabelsList $labels
     */
    public function __construct(MetricName $name, MetricType $type, string $help, MetricLabelsList $labels)
    {
        $this->name   = $name;
        $this->type   = $type;
        $this->help   = $help;
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
