<?php

use Gebrail\ChartsReports\Tests\TestCase;

class GenerateSimpleColumnChartTest extends TestCase
{

    /** @test  */
     function generate_a_simple_column_chart()
        {
            $data = collect([
                ['date'=>1637384400000,'value'=>37],
                ['date'=>1637470800000,'value'=>93],
                ['date'=>1637557200000,'value'=>47],
                ['date'=>1637643600000,'value'=>93],
                ['date'=>1637730000000,'value'=>95],
                ['date'=>1637816400000,'value'=>62],
                ['date'=>1637902800000,'value'=>95],
                ['date'=>1637989200000,'value'=>18],
                ['date'=>1638075600000,'value'=>95],
                ['date'=>1638162000000,'value'=>46],]);
            $options = [
                'chart_name'=>'Simple column',
                'chart_type'=>'Column & Bar',
                'chart_subtype'=>'Simple Column',
                'chart_data'=>$data,
                'categoryXField'=>'date',
                'categoryYField'=>'value',
                'chart_time'=>'day'
            ];

            $response = $this->post('chart-testing',['options' => $options]);

            $response->assertOk();

            $response->assertViewIs('charts-reports::test');

        }

    /** @test  */
    function a_chart_requiere_a_xfield()
    {
        $data = collect(['date', 'value']);

        $data->combine([1637384400000,97],[1637470800000,93],[1637557200000,97]);

        $options = [
            'chart_name'=>'Simple column chart',
            'chart_type'=>'Column & Bar',
            'chart_subtype'=>'Simple Column',
            'chart_data'=>$data,
            'categoryXField'=>'',

        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing',['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify categoryXField option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

            return;
        }
    }

    /** @test  */
    function a_chart_requiere_a_yfield()
    {
        $data = collect(['date', 'value']);

        $data->combine([1637384400000,97],[1637470800000,93],[1637557200000,97]);

        $options = [
            'chart_name'=>'Simple column chart',
            'chart_type'=>'Column & Bar',
            'chart_subtype'=>'Simple Column',
            'chart_data'=>$data,
            'categoryXField'=>'date',
            'categoryYField'=>'',
        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing',['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify categoryYField option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

            return;
        }
    }

    /** @test  */
    function generate_a_chart_with_parse()
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
            'chart_name'=>'Simple column',
            'chart_type'=>'Column & Bar',
            'chart_subtype'=>'Simple Column',
            'chart_data'=>$data,
            'categoryXField'=>'fecha',
            'categoryYField'=>'ventas',
            'chart_time'=>'day',
            'parse_date'=>'yes',
        ];
        $response = $this->post('chart-testing',['options' => $options]);

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }

}