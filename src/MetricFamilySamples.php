<?php

declare(strict_types=1);

namespace Shureban\LaravelPrometheus;

class MetricFamilySamples
{
    private string $name;
    private string $type;
    private string $help;
    private array  $samples;

    /**
     * @param array $meta
     * @param array $samples
     */
    public function __construct(array $meta, array $samples)
    {
        $this->name    = $meta['name'];
        $this->type    = $meta['type'];
        $this->help    = $meta['help'];
        $this->samples = $samples;
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
     * @return array
     */
    public function getSamples(): array
    {
        return $this->samples;
    }
}
