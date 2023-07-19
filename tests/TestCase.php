<?php

namespace Tapp\BladeUppy\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tapp\BladeUppy\BladeUppyServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BladeUppyServiceProvider::class,
        ];
    }
}
