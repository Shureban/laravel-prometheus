<?php

declare(strict_types=1);

namespace Shureban\LaravelPrometheus;

class MetricFamilySamples
{
    /**
     * @var mixed
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $help;

    /**
     * @var string[]
     */
    private $labelNames;

    /**
     * @var Sample[]
     */
    private $samples = [];

    /**
     * @param mixed[] $meta
     */
    public function __construct(array $meta, array $samples)
    {
        $this->name       = $meta['name'];
        $this->type       = $meta['type'];
        $this->help       = $meta['help'];
        $this->labelNames = $meta['labelNames'];
        $this->samples    = $samples;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getHelp(): string
    {
        return $this->help;
    }

    /**
     * @return Sample[]
     */
    public function getSamples(): array
    {
        return $this->samples;
    }

    /**
     * @return string[]
     */
    public function getLabelNames(): array
    {
        return $this->labelNames;
    }

    /**
     * @return bool
     */
    public function hasLabelNames(): bool
    {
        return $this->labelNames !== [];
    }
}
