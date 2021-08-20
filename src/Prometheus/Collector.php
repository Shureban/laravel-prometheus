<?php

declare(strict_types=1);

namespace Shureban\LaravelPrometheus\Prometheus;

use InvalidArgumentException;
use Shureban\LaravelPrometheus\Prometheus\Storage\Storage;
use Shureban\LaravelPrometheus\Prometheus\Attributes\MetricName;
use Shureban\LaravelPrometheus\Prometheus\Attributes\MetricNamespace;
use Shureban\LaravelPrometheus\Prometheus\Attributes\MetricLabelsList;

abstract class Collector
{
    protected Storage          $storage;
    protected MetricNamespace  $namespace;
    protected MetricName       $name;
    protected MetricLabelsList $labels;
    protected string           $help;

    /**
     * @param MetricNamespace  $namespace
     * @param MetricName       $name
     * @param string           $help
     * @param MetricLabelsList $labels
     */
    public function __construct(MetricNamespace $namespace, MetricName $name, string $help, MetricLabelsList $labels)
    {
        $this->storage   = app(config('prometheus.storage_adapter_class'));
        $this->namespace = $namespace;
        $metricName      = ($namespace->isEmpty() ? '' : $namespace . '_') . $name;
        $this->name      = new MetricName($metricName);
        $this->help      = $help;
        $this->labels    = $labels;
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
