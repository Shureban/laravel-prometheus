<?php

namespace Shureban\LaravelPrometheus\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
        return __DIR__ . '/stubs/gauge.stub';
    }
}
