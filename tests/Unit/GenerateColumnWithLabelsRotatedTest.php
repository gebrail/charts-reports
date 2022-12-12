<?php

use Gebrail\ChartsReports\Tests\TestCase;

class GenerateColumnWithLabelsRotatedTest extends TestCase
{

    /** @test  */
    function a_chart_requiere_a_xfield()
    {
        $data = collect(['date', 'value']);

        $data->combine([1637384400000,97],[1637470800000,93],[1637557200000,97]);

        $options = [
            'chart_name'=>'Column With Rotated Labels',
            'chart_type'=>'Column & Bar',
            'chart_subtype'=>'column with rotated labels',
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
            'chart_name'=>'Column With Rotated Labels',
            'chart_type'=>'Column & Bar',
            'chart_subtype'=>'column with rotated labels',
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
    function generate_a_chart_column_with_labels_rotated()
    {

        $data = collect([
            ['vendedor'=>'Jorge','ventas'=>37],
            ['vendedor'=>'Carlos','ventas'=>93],
            ['vendedor'=>'Maria','ventas'=>47],
            ['vendedor'=>'Pedro','ventas'=>93],
            ['vendedor'=>'Tatiana','ventas'=>95],
            ['vendedor'=>'Sergio','ventas'=>62],
            ['vendedor'=>'Marlon','ventas'=>95],
            ['vendedor'=>'Enrrique','ventas'=>18],
            ['vendedor'=>'Jose','ventas'=>95],
            ['vendedor'=>'Moises','ventas'=>46],]);

        $options = [
            'chart_name'=>'Column With Rotated Labels',
            'chart_type'=>'Column & Bar',
            'chart_subtype'=>'column with rotated labels',
            'chart_data'=>$data,
            'categoryXField'=>'vendedor',
            'categoryYField'=>'ventas'
        ];

        $response = $this->post('chart-testing',['options' => $options]);

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }




}