<?php

namespace Shureban\LaravelPrometheus\Prometheus;

use Shureban\LaravelPrometheus\Prometheus\Enums\MetricType;

class Counter extends Collector
{
    /**
     * @param string[] $labelsValues e.g. ['status', 'opcode']
     */
    public function inc(array $labelsValues = []): void
    {
        $this->incBy(1, $labelsValues);
    }

    /**
     * @param int|float $count        e.g. 2
     * @param array     $labelsValues e.g. ['status', 'opcode']
     */
    public function incBy($count, array $labelsValues = []): void
    {
        $this->assertLabelsAreDefinedCorrectly($labelsValues);

        $this->storage->updateCounter(
            [
                'name'        => $this->name,
                'help'        => $this->help,
                'type'        => MetricType::Counter(),
                'labelNames'  => $this->labels,
                'labelValues' => $labelsValues,
                'value'       => $count,
            ]
        );
    }
}
