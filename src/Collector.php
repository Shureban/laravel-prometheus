<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Storage\Storage;
use Shureban\LaravelPrometheus\Attributes\MetricName;
use Shureban\LaravelPrometheus\Attributes\MetricLabels;

abstract class Collector
{
    protected Storage      $storage;
    protected MetricName   $name;
    protected MetricLabels $labels;
    protected string       $help;

    /**
     * @param MetricName   $name
     * @param string       $help
     * @param MetricLabels $labels
     */
    public function __construct(MetricName $name, MetricLabels $labels, string $help)
    {
        $namespace     = $this->getNamespace();
        $this->name    = MetricName::newWithNamespace($name, $namespace);
        $this->storage = $this->getStorage();
        $this->labels  = $labels;
        $this->help    = $help;
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
     * @return MetricName
     */
    public function getName(): MetricName
    {
        return $this->name;
    }

    /**
     * @return MetricLabels
     */
    public function getLabels(): MetricLabels
    {
        return $this->labels;
    }

    /**
     * @return string
     */
    public function getHelp(): string
    {
        return $this->help;
    }
}
