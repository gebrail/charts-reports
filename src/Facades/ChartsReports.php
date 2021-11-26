<?php

namespace Gebrail\ChartsReports\Facades;

use Illuminate\Support\Facades\Facade;

class ChartsReports extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'charts-reports';
    }
}