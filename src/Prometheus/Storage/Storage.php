<?php

declare(strict_types=1);

namespace Shureban\LaravelPrometheus\Prometheus\Storage;

interface Storage
{

    /**
     * @param mixed[] $data
     *
     * @return void
     */
    public function updateCounter(array $data): void;
    public function collectCounters(): array;
}
