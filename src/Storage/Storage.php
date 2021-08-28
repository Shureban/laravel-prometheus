<?php

namespace Shureban\LaravelPrometheus\Storage;

use Shureban\LaravelPrometheus\Collector;

interface Storage
{

    /**
     * @param Collector $collector
     * @param float     $count
     *
     * @return void
     */
    public function updateCounter(Collector $collector, float $count): void;
    public function collectCounters(): array;
}
