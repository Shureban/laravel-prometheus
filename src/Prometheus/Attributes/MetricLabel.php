<?php

namespace Shureban\LaravelPrometheus\Prometheus\Attributes;

use Stringable;
use InvalidArgumentException;

class MetricLabel implements Stringable, \JsonSerializable
{
    private const Regex = '/^[a-zA-Z][a-zA-Z0-9_:]*$/';

    private string $label;

    /**
     * @param string $label
     */
    public function __construct(string $label)
    {
        if (preg_match(self::Regex, $label) !== 1) {
            throw new InvalidArgumentException("Invalid metric label name: '" . $label . "'");
        }

        $this->label = $label;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->label;
    }

    /**
     * @return mixed|void
     */
    public function jsonSerialize(): string
    {
        return $this->label;
    }
}
