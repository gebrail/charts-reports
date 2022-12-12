<?php

namespace Gebrail\ChartsReports;

use Illuminate\Support\ServiceProvider;
use Gebrail\ChartsReports\Console\ChartsReports;

class ChartsReportsServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'charts-reports');
        if ($this->app->runningInConsole()) {
            $this->commands([
                ChartsReports::class,
            ]);
        }
    }

    public function register(){
    }

}