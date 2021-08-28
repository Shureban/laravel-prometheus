<?php

namespace Shureban\LaravelPrometheus\Attributes;

use JsonSerializable;
use Shureban\LaravelPrometheus\Enums\MetricType;

class MetaInformation implements JsonSerializable
{
    private MetricName $name;
    private MetricType $type;
    private string     $help;

    /**
     * @param MetricName $name
     * @param MetricType $type
     * @param string     $help
     */
    public function __construct(MetricName $name, MetricType $type, string $help)
    {
        $this->name = $name;
        $this->type = $type;
        $this->help = $help;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'help' => $this->help,
            'type' => $this->type,
        ];
    }
}
