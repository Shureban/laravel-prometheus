<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Interfaces\Increment;

/**
 * @method Counter withLabelsValues(array $labelsValues)
 */
class Counter extends Collector implements Increment
{
    /**
     * @inheritDoc
     */
    public function inc(): void
    {
        $this->incBy(1);
    }

    /**
     * @inheritDoc
     *
     * @param int|float $count e.g. 2
     *
     * @return void
     */
    public function incBy(float $count): void
    {
        $this->storage->updateCounter($this, $count);
    }
}
