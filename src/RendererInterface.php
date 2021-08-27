<?php

namespace Shureban\LaravelPrometheus;

interface RendererInterface
{
    /**
     * @return string
     */
    public function render(): string;
}
