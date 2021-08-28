<?php

namespace Shureban\LaravelPrometheus\Interfaces;

interface Set
{
    /**
     * Set new metric value
     *
     * @param float $count
     */
    public function set(float $count): void;
}
