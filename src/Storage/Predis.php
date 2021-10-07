<?php

namespace Shureban\LaravelPrometheus\Storage;

use Predis\Client;
use Illuminate\Redis\RedisManager;
use Shureban\LaravelPrometheus\DynamicCollector;
use Shureban\LaravelPrometheus\Enums\MetricType;
use Shureban\LaravelPrometheus\Interfaces\Storage;
use Shureban\LaravelPrometheus\MetricFamilySamples;
use Shureban\LaravelPrometheus\Attributes\MetaInformation;
use Shureban\LaravelPrometheus\Attributes\MetricsStorageKey;
use Shureban\LaravelPrometheus\Attributes\GaugeMetricsStorageName;
use Shureban\LaravelPrometheus\Attributes\CounterMetricsStorageName;

/**
 * Class Predis
 *
 * @package App\Components\Storage
 */
class Predis implements Storage
{
    /**
     * @var RedisManager|Client
     */
    private $redis;

    public function __construct()
    {
        $this->redis = app('redis');
    }

    /**
     * @inheritDoc
     *
     * @param DynamicCollector $collector
     * @param float            $count
     *
     * @return void
     */
    public function updateCounter(DynamicCollector $collector, float $count): void
    {
        $metricType = MetricType::Counter();
        $metricKey  = new MetricsStorageKey($collector->getName(), $metricType);
        $meta       = new MetaInformation($collector->getName(), $metricType, $collector->getHelp());

        $this->redis->hset(new CounterMetricsStorageName(), $metricKey, json_encode($meta));
        $this->redis->hIncrByFloat($metricKey, $collector->getLabels(), $count);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function collectCounters(): array
    {
        $metricsKeys = $this->redis->hgetall(new CounterMetricsStorageName());
        $counters    = [];

        foreach ($metricsKeys as $metricKey => $meta) {
            $meta       = json_decode($meta, true);
            $metricData = $this->redis->hgetall($metricKey);
            $counters[] = new MetricFamilySamples($meta, $metricData);
        }

        return $counters;
    }

    /**
     * @inheritDoc
     *
     * @param DynamicCollector $collector
     * @param float            $count
     */
    public function updateGauge(DynamicCollector $collector, float $count): void
    {
        $metricType = MetricType::Gauge();
        $metricKey  = new MetricsStorageKey($collector->getName(), $metricType);
        $meta       = new MetaInformation($collector->getName(), $metricType, $collector->getHelp());

        $this->redis->hset(new GaugeMetricsStorageName(), $metricKey, json_encode($meta));
        $this->redis->hIncrByFloat($metricKey, $collector->getLabels(), $count);
    }

    /**
     * @inheritDoc
     *
     * @param DynamicCollector $collector
     * @param float            $count
     */
    public function setGauge(DynamicCollector $collector, float $count): void
    {
        $metricType = MetricType::Gauge();
        $metricKey  = new MetricsStorageKey($collector->getName(), $metricType);
        $meta       = new MetaInformation($collector->getName(), $metricType, $collector->getHelp());

        $this->redis->hset(new GaugeMetricsStorageName(), $metricKey, json_encode($meta));
        $this->redis->hset($metricKey, $collector->getLabels(), $count);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function collectGauges(): array
    {
        $metricsKeys = $this->redis->hgetall(new GaugeMetricsStorageName());
        $counters    = [];

        foreach ($metricsKeys as $metricKey => $meta) {
            $meta       = json_decode($meta, true);
            $metricData = $this->redis->hgetall($metricKey);
            $counters[] = new MetricFamilySamples($meta, $metricData);
        }

        return $counters;
    }
}
