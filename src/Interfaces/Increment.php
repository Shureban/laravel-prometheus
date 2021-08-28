<?php

namespace Shureban\LaravelPrometheus\Interfaces;

interface Increment
{
    /**
     * Increase the metric value by 1
     *
     * @return void
     */
    public function inc(): void;

    /**
     * Increase the metric value by $count
     *
     * @param int|float $count e.g. 2
     *
     * @return void
     */
    public function incBy(float $count): void;
}
