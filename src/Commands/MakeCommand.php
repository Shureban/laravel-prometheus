<?php

namespace Shureban\LaravelPrometheus\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Shureban\LaravelPrometheus\Enums\MetricType;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class MakeCommand extends GeneratorCommand
{
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Prometheus metric';

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $stub       = parent::replaceClass($stub, $name);
        $metricName = $this->option('name');

        if (!$metricName) {
            $types      = array_map(fn(MetricType $type) => $type->value, MetricType::cases());
            $metricName = Str::snake($this->getNameInput());
            $metricName = str_replace($types, '', $metricName);
            $metricName = str_replace('__', '_', $metricName);
            $metricName = trim($metricName, '_');
        }

        $labels = explode(',', $this->option('labels'));
        $labels = array_map(fn(string $label) => sprintf("'%s'", $label), $labels);
        $labels = implode(',', $labels);

        $stub = str_replace('{{ name }}', $metricName, $stub);
        $stub = str_replace('{{ labels }}', $labels, $stub);

        return str_replace('{{ description }}', $this->option('description'), $stub);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return config('prometheus.storage_path') ?: $rootNamespace;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the metric class'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['name', null, InputOption::VALUE_OPTIONAL, 'Name of the metric'],
            ['labels', null, InputOption::VALUE_OPTIONAL, 'The metric labels list (comma separated)'],
            ['description', null, InputOption::VALUE_OPTIONAL, 'The metric description'],
            ['dynamic', 'd', InputOption::VALUE_NONE, 'Create dynamic metric option'],
        ];
    }
}
