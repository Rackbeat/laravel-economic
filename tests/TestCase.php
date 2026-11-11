<?php

namespace Tests;

use LasseRafn\Economic\EconomicServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [EconomicServiceProvider::class];
    }
}
