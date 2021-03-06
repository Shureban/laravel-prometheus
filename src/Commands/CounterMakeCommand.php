<?php

namespace Shureban\LaravelPrometheus\Commands;

class CounterMakeCommand extends MakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:counter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new counter metric';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->option('dynamic')
            ? __DIR__ . '/stubs/counter.stub'
            : __DIR__ . '/stubs/dynamic_counter.stub';
    }
}
