<?php

namespace Shureban\LaravelPrometheus\Interfaces;

interface RendererInterface
{
    /**
     * @return string
     */
    public function render(): string;
}
