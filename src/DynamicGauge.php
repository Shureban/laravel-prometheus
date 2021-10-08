<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Interfaces\Set;
use Shureban\LaravelPrometheus\Attributes\Labels;
use Shureban\LaravelPrometheus\Interfaces\Increment;
use Shureban\LaravelPrometheus\Interfaces\Decrement;

/**
 * @method DynamicGauge withLabels(Labels $labels)
 */
abstract class DynamicGauge extends DynamicCollector implements Increment, Decrement, Set
{
    /**
     * @inheritDoc
     *
     * @param float $count
     */
    public function set(float $count): void
    {
        $this->storage->setGauge($this, $count);
    }

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
        $this->storage->updateGauge($this, $count);
    }

    /**
     * @inheritDoc
     */
    public function dec(): void
    {
        $this->incBy(-1);
    }

    /**
     * @inheritDoc
     *
     * @param float $count
     */
    public function decBy(float $count): void
    {
        $this->incBy(-$count);
    }
}
