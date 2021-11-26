<?php

namespace Gebrail\ChartsReports;

use Illuminate\Support\ServiceProvider;

class ChartsReportsServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'charts-reports');
    }

    public function register(){
    }

}