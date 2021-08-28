<?php

namespace Shureban\LaravelPrometheus\Interfaces;

interface Decrement
{
    /**
     * Decrease the metric value by 1
     *
     * @return void
     */
    public function dec(): void;

    /**
     * Decrease the metric value by $count
     *
     * @param int|float $count e.g. 2
     *
     * @return void
     */
    public function decBy(float $count): void;
}
