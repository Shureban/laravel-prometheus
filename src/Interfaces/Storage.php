<?php

namespace Shureban\LaravelPrometheus\Interfaces;

use Shureban\LaravelPrometheus\DynamicCollector;

interface Storage
{
    /**
     * Increment counter metrics value
     *
     * @param DynamicCollector $collector
     * @param float     $count
     *
     * @return void
     */
    public function updateCounter(DynamicCollector $collector, float $count): void;

    /**
     * Return list of counters metrics data
     *
     * @return array
     */
    public function collectCounters(): array;

    /**
     * Increment or decrement gauge metrics value
     *
     * @param DynamicCollector $collector
     * @param float     $count
     *
     * @return void
     */
    public function updateGauge(DynamicCollector $collector, float $count): void;

    /**
     * Set new gauge metrics value
     *
     * @param DynamicCollector $collector
     * @param float     $count
     */
    public function setGauge(DynamicCollector $collector, float $count): void;

    /**
     * Return list of gauges metrics data
     *
     * @return array
     */
    public function collectGauges(): array;
}
