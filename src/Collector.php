<?php

namespace Shureban\LaravelPrometheus;

use InvalidArgumentException;
use Shureban\LaravelPrometheus\Storage\Storage;
use Shureban\LaravelPrometheus\Attributes\MetricName;
use Shureban\LaravelPrometheus\Attributes\MetricLabelsList;

abstract class Collector
{
    protected Storage          $storage;
    protected MetricName       $name;
    protected MetricLabelsList $labels;
    protected string           $help;

    /**
     * @param MetricName       $name
     * @param string           $help
     * @param MetricLabelsList $labels
     */
    public function __construct(MetricName $name, string $help, MetricLabelsList $labels)
    {
        $namespace     = $this->getNamespace();
        $this->storage = $this->getStorage();
        $this->help    = $help;
        $this->labels  = $labels;
        $this->name    = MetricName::newWithNamespace($name, $namespace);
    }

    /**
     * @return Storage
     */
    protected function getStorage(): Storage
    {
        return app(config('prometheus.storage_adapter_class'));
    }

    /**
     * @return string
     */
    protected function getNamespace(): string
    {
        return config('prometheus.project_namespace');
    }

    /**
     * @param string[] $labels
     */
    protected function assertLabelsAreDefinedCorrectly(array $labels): void
    {
        if (count($labels) !== $this->labels->count()) {
            throw new InvalidArgumentException(sprintf('Labels are not defined correctly: %s', print_r($labels, true)));
        }
    }
}
