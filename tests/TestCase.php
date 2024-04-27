<?php

namespace ievtds\Apexcharts\Tests;

use ievtds\Apexcharts\Facade;
use ievtds\Apexcharts\Provider;
use Orchestra\Testbench\TestCase as TestBenchTestCase;

class TestCase extends TestBenchTestCase
{
    /**
     * Load the package service provider.
     */
    protected function getPackageProviders($app): array
    {
        return [
            Provider::class,
        ];
    }
}
