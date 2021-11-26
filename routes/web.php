<?php

use Gebrail\ChartsReports\ChartReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/chart-testing', function (Request $request) {

    $chart = new ChartReport($request->options);

    return view('charts-reports::test', compact('chart'));

});