<?php

namespace Shureban\LaravelPrometheus\Prometheus\Storage;

use Predis\Client;
use Illuminate\Redis\RedisManager;
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
        $metricKey = new MetricKey($data['type'], $data['name']);
        $metaData  = new MetaData($data['name'], $data['help'], $data['type'], $data['labelNames']);

        $redis->sadd(new CounterMetricsStorageName(), [$metricKey]);
        $redis->hset($metricKey, '__meta', json_encode($metaData));
        $redis->hIncrByFloat($metricKey, json_encode($data['labelValues']), $data['value']);
    }

    /**
     * @return array
     */
    public function collectCounters(): array
    {
        /** @var RedisManager|Client $redis */
        $redis    = app('redis');
        $keys     = $redis->smembers(new CounterMetricsStorageName());
        $counters = [];

        foreach ($keys as $key) {
            $raw                = $redis->hgetall($key);
            $counter            = json_decode($raw['__meta'], true);
            $counter['samples'] = [];

            unset($raw['__meta']);

            foreach ($raw as $k => $value) {
                $sample               = [
                    'name'        => $counter['name'],
                    'labelNames'  => [],
                    'labelValues' => json_decode($k, true),
                    'value'       => $value,
                ];
                $counter['samples'][] = $sample;
            }

            $counters[] = new MetricFamilySamples($counter);
        }

        return $counters;
    }
}
