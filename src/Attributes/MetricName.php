<?php

namespace Shureban\LaravelPrometheus\Attributes;

use Stringable;
use InvalidArgumentException;

class MetricName implements Stringable, \JsonSerializable
{
    private const Regex = '/^[a-zA-Z][a-zA-Z0-9_:]*$/';

    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (preg_match(self::Regex, $name) !== 1) {
            throw new InvalidArgumentException("Invalid metric name: '" . $name . "'");
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): string
    {
        return $this->name;
    }
}
