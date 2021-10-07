<?php

namespace Shureban\LaravelPrometheus\Attributes;

use Stringable;
use JsonSerializable;
use InvalidArgumentException;
use Illuminate\Support\Collection;
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
     * Constructor polymorph
     *
     * @param array $array
     *
     * @return Labels
     */
    public static function newFromArray(array $array): Labels
    {
        $labels = new Labels(array_keys($array));
        $labels->setLabelsValues(array_values($array));

        return $labels;
    }

    /**
     * Constructor polymorph
     *
     * @param Collection $collection
     *
     * @return Labels
     */
    public static function newFromCollection(Collection $collection): Labels
    {
        return Labels::newFromArray($collection->toArray());
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
