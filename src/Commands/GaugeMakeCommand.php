<?php

namespace Shureban\LaravelPrometheus\Commands;

class GaugeMakeCommand extends MakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:gauge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new gauge metric';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->option('dynamic')
            ? __DIR__ . '/stubs/gauge.stub'
            : __DIR__ . '/stubs/dynamic_gauge.stub';
    }
}
