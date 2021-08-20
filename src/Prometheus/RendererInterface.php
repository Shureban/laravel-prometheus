<?php

namespace Shureban\LaravelPrometheus\Prometheus;

interface RendererInterface
{
    /**
     * @return string
     */
    public function render(): string;
}
