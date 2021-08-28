<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Storage\Storage;

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
        $metrics = $this->storage->collectCounters();

        /** @var MetricFamilySamples $metric */
        foreach ($metrics as $metric) {
            $lines[] = sprintf('# HELP %s %s', $metric->getName(), $metric->getHelp());
            $lines[] = sprintf('# TYPE %s %s', $metric->getName(), $metric->getType());

            foreach ($metric->getSamples() as $labels => $count) {
                $lines[] = sprintf('%s%s %s', $metric->getName(), $labels, $count);
            }
        }

        return implode("\n", $lines) . "\n";
    }
}
