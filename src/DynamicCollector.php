<?php

namespace Shureban\LaravelPrometheus;

use Shureban\LaravelPrometheus\Attributes\Name;
use Shureban\LaravelPrometheus\Attributes\Labels;
use Shureban\LaravelPrometheus\Interfaces\Storage;

abstract class DynamicCollector
{
    protected Storage $storage;
    protected Name    $name;
    protected Labels  $labels;
    protected string  $help;

    /**
     * @param Name   $name
     * @param string $help
     */
    public function __construct(Name $name, string $help)
    {
        $this->storage = $this->getStorage();
        $this->name    = Name::newWithNamespace($name, $this->getNamespace());
        $this->help    = $help;
    }

    /**
     * @return Storage
     */
    protected function getStorage(): Storage
    {
        return app(config('prometheus.storage_adapter_class'));
    }

    /**
     * @return string
     */
    protected function getNamespace(): string
    {
        return config('prometheus.project_namespace');
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Labels
     */
    public function getLabels(): Labels
    {
        return $this->labels;
    }

    /**
     * @return string
     */
    public function getHelp(): string
    {
        return $this->help;
    }

    /**
     * @param Labels $labels
     *
     * @return DynamicCollector
     */
    public function withLabels(Labels $labels): DynamicCollector
    {
        $this->labels = $labels;

        return $this;
    }
}
