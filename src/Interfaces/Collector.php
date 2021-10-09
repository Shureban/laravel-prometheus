<?php

namespace Shureban\LaravelPrometheus\Interfaces;

use Shureban\LaravelPrometheus\Attributes\Name;
use Shureban\LaravelPrometheus\Attributes\Labels;

interface Collector
{
    /**
     * Return metric name
     *
     * @return Name
     */
    public function getName(): Name;

    /**
     * Return metric labels
     *
     * @return Labels
     */
    public function getLabels(): Labels;

    /**
     * Return metric description
     *
     * @return string
     */
    public function getHelp(): string;
}
