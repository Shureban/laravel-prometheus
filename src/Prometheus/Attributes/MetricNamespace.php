<?php

namespace Shureban\LaravelPrometheus\Prometheus\Attributes;

use Stringable;
use InvalidArgumentException;

class MetricNamespace implements Stringable
{
    private const Regex = '/^[a-zA-Z][a-zA-Z0-9_:]*$/';

    private string $namespace;

    /**
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        if (preg_match(self::Regex, $namespace) !== 1) {
            throw new InvalidArgumentException("Invalid metric namespace: '" . $namespace . "'");
        }

        $this->namespace = $namespace;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->namespace === '';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->namespace;
    }
}
