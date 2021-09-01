<?php

namespace Shureban\LaravelPrometheus;

use Stringable;
use Shureban\LaravelPrometheus\Interfaces\Storage;
use Shureban\LaravelPrometheus\Interfaces\RendererInterface;

class RenderTextFormat implements RendererInterface, Stringable
{
    const MIME_TYPE = 'text/plain; version=0.0.4';

    private Storage $storage;

    /**
     * CollectorRegistry constructor.
     */
    public function __construct()
    {
        $this->storage = $this->getStorage();
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
    public function render(): string
    {
        $lines   = [];
        $metrics = array_merge($this->storage->collectCounters(), $this->storage->collectGauges());

        /** @var MetricFamilySamples $metric */
        foreach ($metrics as $metric) {
            $lines[] = $this->renderHelpLine($metric);
            $lines[] = $this->renderTypeLine($metric);

            foreach ($metric->getSamples() as $labels => $count) {
                $lines[] = $this->renderSampleLine($metric->getName(), $labels, $count);
            }
        }

        return implode("\n", $lines) . "\n";
    }

    /**
     * @param MetricFamilySamples $metric
     *
     * @return string
     */
    private function renderHelpLine(MetricFamilySamples $metric): string
    {
        return sprintf('# HELP %s %s', $metric->getName(), $metric->getHelp());
    }

    /**
     * @param MetricFamilySamples $metric
     *
     * @return string
     */
    private function renderTypeLine(MetricFamilySamples $metric): string
    {
        return sprintf('# TYPE %s %s', $metric->getName(), $metric->getType());
    }

    /**
     * @param string $metricName
     * @param string $labels
     * @param float  $count
     *
     * @return string
     */
    private function renderSampleLine(string $metricName, string $labels, float $count): string
    {
        return sprintf('%s%s %s', $metricName, $labels, $count);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
