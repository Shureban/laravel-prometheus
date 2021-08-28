<?php

namespace Shureban\LaravelPrometheus\Attributes;

use Stringable;
use JsonSerializable;
use InvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;

class Labels implements Arrayable, JsonSerializable, Stringable
{
    private array $labelsNames;
    private array $labelsValues = [];

    /**
     * @param array $labelsNames
     */
    public function __construct(array $labelsNames = [])
    {
        $this->labelsNames = $labelsNames;
    }

    /**
     * @param array $labelsValues
     */
    public function setLabelsValues(array $labelsValues): void
    {
        if (count($this->labelsNames) !== count($labelsValues)) {
            throw new InvalidArgumentException(sprintf('Labels are not defined correctly: %s', print_r($labelsValues, true)));
        }

        $this->labelsValues = $labelsValues;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (count($this->labelsNames) === 0) {
            return '';
        }

        $result = [];

        foreach ($this->toArray() as $name => $value) {
            $result[] = sprintf('%s="%s"', $name, $value);
        }

        return sprintf('{%s}', implode(',', $result));
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_combine($this->labelsNames, $this->labelsValues);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
