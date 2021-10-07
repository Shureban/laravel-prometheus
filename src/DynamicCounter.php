<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Interfaces\Increment;

/**
 * @method DynamicCounter withLabels(array $labelsValues)
 */
abstract class DynamicCounter extends DynamicCollector implements Increment
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
