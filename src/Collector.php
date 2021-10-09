<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Attributes\Name;
use Shureban\LaravelPrometheus\Attributes\Labels;

abstract class Collector extends DynamicCollector
{
    /**
     * @param Name   $name
     * @param string $help
     * @param Labels $labels
     */
    public function __construct(Name $name, Labels $labels, string $help)
    {
        parent::__construct($name, $help);

        $this->labels = $labels;
    }

    /**
     * @param array $labelsValues
     *
     * @return Collector
     */
    public function withLabelsValues(array $labelsValues): Collector
    {
        $this->labels->setLabelsValues($labelsValues);

        return $this;
    }
}
