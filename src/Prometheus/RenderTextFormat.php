<?php

namespace Shureban\LaravelPrometheus\Prometheus;

use Shureban\LaravelPrometheus\Prometheus\Storage\Storage;

class RenderTextFormat implements RendererInterface
{
    const MIME_TYPE = 'text/plain; version=0.0.4';

    private Storage $storage;

    /**
     * CollectorRegistry constructor.
     */
    public function __construct()
    {
        $this->storage = app(config('prometheus.storage_adapter_class'));
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $lines   = [];
        $metrics = [];
        $metrics = array_merge($metrics, $this->storage->collectCounters());

        /** @var MetricFamilySamples $metric */
        foreach ($metrics as $metric) {
            $lines[] = "# HELP " . $metric->getName() . " {$metric->getHelp()}";
            $lines[] = "# TYPE " . $metric->getName() . " {$metric->getType()}";

            foreach ($metric->getSamples() as $sample) {
                $lines[] = $this->renderSample($metric, $sample);
            }
        }

        return implode("\n", $lines) . "\n";
    }

    /**
     * @param MetricFamilySamples $metric
     * @param Sample              $sample
     *
     * @return string
     */
    private function renderSample(MetricFamilySamples $metric, Sample $sample): string
    {
        $labelNames = $metric->getLabelNames();

        if ($metric->hasLabelNames() || $sample->hasLabelNames()) {
            $escapedLabels = $this->escapeAllLabels($labelNames, $sample);
            return $sample->getName() . '{' . implode(',', $escapedLabels) . '} ' . $sample->getValue();
        }

        return $sample->getName() . ' ' . $sample->getValue();
    }

    /**
     * @param string[] $labelNames
     * @param Sample   $sample
     *
     * @return string[]
     */
    private function escapeAllLabels(array $labelNames, Sample $sample): array
    {
        $escapedLabels = [];

        $labels = array_combine(array_merge($labelNames, $sample->getLabelNames()), $sample->getLabelValues());

        if ($labels === false) {
            return [];
        }

        foreach ($labels as $labelName => $labelValue) {
            $escapedLabels[] = $labelName . '="' . $this->escapeLabelValue((string)$labelValue) . '"';
        }

        return $escapedLabels;
    }

    /**
     * @param string $v
     *
     * @return string
     */
    private function escapeLabelValue(string $v): string
    {
        return str_replace(["\\", "\n", "\""], ["\\\\", "\\n", "\\\""], $v);
    }
}
