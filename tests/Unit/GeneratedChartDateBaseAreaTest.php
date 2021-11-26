<?php

use Gebrail\ChartsReports\Tests\TestCase;

class GeneratedChartDateBaseAreaTest extends TestCase
{

    /** @test  */
    function generate_a_chart()
    {
        $data = collect([
            ['fecha'=>\Carbon\Carbon::create(2021,11,11,12),'ventas'=>97],
            ['fecha'=>\Carbon\Carbon::create(2021,11,12,12),'ventas'=>93],
            ['fecha'=>\Carbon\Carbon::create(2021,11,13,12),'ventas'=>97],
            ['fecha'=>\Carbon\Carbon::create(2021,11,14,12),'ventas'=>93],
            ['fecha'=>\Carbon\Carbon::create(2021,11,15,12),'ventas'=>95],
            ['fecha'=>\Carbon\Carbon::create(2021,11,16,12),'ventas'=>92],
            ['fecha'=>\Carbon\Carbon::create(2021,11,17,12),'ventas'=>95],
            ['fecha'=>\Carbon\Carbon::create(2021,11,18,12),'ventas'=>98],
            ['fecha'=>\Carbon\Carbon::create(2021,11,19,12),'ventas'=>95],
            ['fecha'=>\Carbon\Carbon::create(2021,11,20,12),'ventas'=>96],
        ]);

        $options = [
            'chart_name' => 'Date Based Data',
            'chart_type' => 'Line & Area',
            'chart_subtype' => 'Date Based Data',
            'categoryXField' => 'fecha',
            'categoryYField' => 'ventas',
            'parse_date'=>'yes',
            'chart_data'=> $data,
        ];

        $response = $this->post('chart-testing',['options' => $options]);

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }
}