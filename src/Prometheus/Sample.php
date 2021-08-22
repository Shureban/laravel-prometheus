<?php

declare(strict_types=1);

namespace Shureban\LaravelPrometheus\Prometheus;

class Sample
{
    private array $labelValues;
    private float $value;

    /**
     * Sample constructor.
     *
     * @param array $labelValues
     * @param float $value
     */
    public function __construct(array $labelValues, float $value)
    {
        $this->labelValues = $labelValues;
        $this->value       = $value;
    }

    /**
     * @return array
     */
    public function getLabelValues(): array
    {
        return $this->labelValues;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
