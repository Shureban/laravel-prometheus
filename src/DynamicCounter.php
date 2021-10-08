<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Attributes\Labels;
use Shureban\LaravelPrometheus\Interfaces\Increment;

/**
 * @method DynamicCounter withLabels(Labels $labels)
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
