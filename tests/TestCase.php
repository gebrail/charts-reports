<?php

namespace Gebrail\ChartsReports\Tests;
use Gebrail\ChartsReports\ChartsReportsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return[
            ChartsReportsServiceProvider::class
        ];
    }
    protected  function getPackageAliases($app)
    {
        return [
            'ChartsReports'=> \Gebrail\ChartsReports\Facades\ChartsReports::class
        ];
    }

}