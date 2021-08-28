<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Interfaces\Incrementer;

class Counter extends Collector implements Incrementer
{
    /**
     * @param array $labelsValues
     *
     * @return Counter
     */
    public function withLabelsValues(array $labelsValues): Counter
    {
        $this->labels->setLabelsValues($labelsValues);

        return $this;
    }

    public function inc(): void
    {
        $this->incBy(1);
    }

    /**
     * @param int|float $count e.g. 2
     *
     * @return void
     */
    public function incBy(float $count): void
    {
        $this->storage->updateCounter($this, $count);
    }
}
