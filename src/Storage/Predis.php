<?php

namespace Shureban\LaravelPrometheus\Storage;

use Predis\Client;
use Illuminate\Redis\RedisManager;
use Shureban\LaravelPrometheus\Collector;
use Shureban\LaravelPrometheus\Enums\MetricType;
use Shureban\LaravelPrometheus\MetricFamilySamples;
use Shureban\LaravelPrometheus\Attributes\MetricKey;
use Shureban\LaravelPrometheus\Attributes\MetaInformation;
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
     * @param Collector $collector
     * @param float     $count
     *
     * @return void
     */
    public function updateCounter(Collector $collector, float $count): void
    {
        $metricType = MetricType::Counter();
        $metricKey  = new MetricKey($collector->getName(), $metricType);
        $meta       = new MetaInformation($collector->getName(), $metricType, $collector->getHelp());

        $this->redis->hset(new CounterMetricsStorageName(), $metricKey, json_encode($meta));
        $this->redis->hIncrByFloat($metricKey, $collector->getLabels(), $count);
    }

    /**
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
}
