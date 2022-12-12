<?php

use Gebrail\ChartsReports\Tests\TestCase;

class GeneratedChartDateBaseAreaTest extends TestCase
{

    /** @test  */
    function generate_a_chart_without_parse_date()
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
            'chart_name' => 'Date Based Data',
            'chart_type' => 'Line & Area',
            'chart_subtype' => 'Date Based Data',
            'categoryXField' => 'date',
            'categoryYField' => 'value',
            'chart_data'=> $data,
            'parse_date' =>'no',
        ];

        $response = $this->post('chart-testing',['options' => $options]);

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }



    /** @test  */
    function generate_a_chart_with_parse_date()
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

    /** @test  */



    /** @test  */
    function a_chart_requiere_a_categoryXfield()
    {
        $data = collect([['fecha'=>\Carbon\Carbon::create(2021,11,11,12),'ventas'=>97], ['fecha'=>\Carbon\Carbon::create(2021,11,12,12),'ventas'=>93],]);

        $options = [
            'chart_name' => 'Date Based Data',
            'chart_type' => 'Line & Area',
            'chart_subtype' => 'Date Based Data',
            'categoryXField' => '',
            'categoryYField' => 'ventas',
            'parse_date'=>'yes',
            'chart_data'=> $data,
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
    function a_chart_requiere_a_categoryYfield()
    {
        $data = collect([['fecha'=>\Carbon\Carbon::create(2021,11,11,12),'ventas'=>97], ['fecha'=>\Carbon\Carbon::create(2021,11,12,12),'ventas'=>93],]);

        $options = [
            'chart_name' => 'Date Based Data',
            'chart_type' => 'Line & Area',
            'chart_subtype' => 'Date Based Data',
            'categoryXField' => 'fecha',
            'categoryYField' => '',
            'parse_date'=>'yes',
            'chart_data'=> $data,
        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing',['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify categoryYField option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

            return;
        }
    }
}