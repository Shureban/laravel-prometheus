<?php

namespace Shureban\LaravelPrometheus\Prometheus\Storage;

use Predis\Client;
use Illuminate\Redis\RedisManager;
use Shureban\LaravelPrometheus\Prometheus\Sample;
use Shureban\LaravelPrometheus\Prometheus\MetricFamilySamples;
use Shureban\LaravelPrometheus\Prometheus\Attributes\MetaData;
use Shureban\LaravelPrometheus\Prometheus\Attributes\MetricKey;
use Shureban\LaravelPrometheus\Prometheus\Attributes\CounterMetricsStorageName;

/**
 * Class Predis
 *
 * @package App\Components\Prometheus\Storage
 */
class Predis implements Storage
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function updateCounter(array $data): void
    {
        /** @var RedisManager|Client $redis */
        $redis     = app('redis');
        $metricKey = new MetricKey($data['name'], $data['type']);
        $metaData  = new MetaData($data['name'], $data['type'], $data['help'], $data['labelNames']);

        $redis->hset(new CounterMetricsStorageName(), $metricKey, json_encode($metaData));
        $redis->hIncrByFloat($metricKey, json_encode($data['labelValues']), $data['value']);
    }

    /**
     * @return array
     */
    public function collectCounters(): array
    {
        /** @var RedisManager|Client $redis */
        $redis       = app('redis');
        $metricsKeys = $redis->hgetall(new CounterMetricsStorageName());
        $counters    = [];

        foreach ($metricsKeys as $metricKey => $meta) {
            $metricData = $redis->hgetall($metricKey);
            $meta       = json_decode($meta, true);
            $samples    = [];

            foreach ($metricData as $labelValues => $count) {
                $labelValues = json_decode($labelValues, true);
                $samples[]   = new Sample($labelValues, $count);
            }

            $counters[] = new MetricFamilySamples($meta, $samples);
        }

        return $counters;
    }
}
