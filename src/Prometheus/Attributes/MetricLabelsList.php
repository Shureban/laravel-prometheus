<?php

namespace Shureban\LaravelPrometheus\Prometheus\Attributes;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;

class MetricLabelsList implements Arrayable, JsonSerializable
{
    private array $labels = [];

    public static function createFromArray(array $labels): MetricLabelsList
    {
        $list = new MetricLabelsList();

        array_map(fn(string $label) => $list->push(new MetricLabel($label)), $labels);

        return $list;
    }

    public function push(MetricLabel $label): void
    {
        $this->labels[] = $label;
    }

    public function count(): int
    {
        return count($this->labels);
    }

    public function toArray(): array
    {
        return $this->labels;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
