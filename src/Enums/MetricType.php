<?php

namespace Shureban\LaravelPrometheus\Enums;

enum MetricType: string
{
    case Counter = 'counter';
    case Gauge = 'gauge';
}
