<?php

namespace Shureban\LaravelPrometheus\Attributes;

use Stringable;
use JsonSerializable;
use InvalidArgumentException;

class Name implements Stringable, JsonSerializable
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
     * @param string $name
     * @param string $namespace
     *
     * @return Name
     */
    public static function newWithNamespace(string $name, string $namespace): Name
    {
        $name = ($namespace === '' ? '' : $namespace . '_') . $name;

        return new Name($name);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return (string)$this;
    }
}
