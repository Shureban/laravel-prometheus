<?php

namespace Shureban\LaravelPrometheus\Interfaces;

interface Incrementer
{
    public function inc(): void;

    public function incBy(float $count): void;
}
