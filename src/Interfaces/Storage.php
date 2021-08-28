<?php

namespace Shureban\LaravelPrometheus\Interfaces;

use Shureban\LaravelPrometheus\Collector;

interface Storage
{
    /**
     * Increment counter metrics value
     *
     * @param Collector $collector
     * @param float     $count
     *
     * @return void
     */
    public function updateCounter(Collector $collector, float $count): void;

    /**
     * Return list of counters metrics data
     *
     * @return array
     */
    public function collectCounters(): array;

    /**
     * Increment or decrement gauge metrics value
     *
     * @param Collector $collector
     * @param float     $count
     *
     * @return void
     */
    public function updateGauge(Collector $collector, float $count): void;

    /**
     * Set new gauge metrics value
     *
     * @param Collector $collector
     * @param float     $count
     */
    public function setGauge(Collector $collector, float $count): void;

    /**
     * Return list of gauges metrics data
     *
     * @return array
     */
    public function collectGauges(): array;
}
