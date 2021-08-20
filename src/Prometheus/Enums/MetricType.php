<?php

namespace Shureban\LaravelPrometheus\Prometheus\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self Counter()
 * @method static self Gauge()
 */
class MetricType extends Enum
{
    public const Counter = 'counter';
    public const Gauge   = 'gauge';
}
