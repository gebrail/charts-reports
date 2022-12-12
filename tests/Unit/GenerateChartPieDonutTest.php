<?php

use Gebrail\ChartsReports\Tests\TestCase;

class GenerateChartPieDonutTest extends TestCase
{
    /** @test  */
    function generate_a_chart_simple_pie()
    {
        $data = collect([['name'=>'maria','ventas'=>97], ['name'=>'Jose','ventas'=>23], ['name'=>'carlos','ventas'=>97], ['name'=>'pedro','ventas'=>33], ['name'=>'marlon','ventas'=>95],]);

        $options = [
            'chart_name' => 'Pie Chart',
            'chart_type' => 'Pie & Donut',
            'chart_subtype' => 'simple pie',
            'field_category' => 'name',
            'field_value' => 'ventas',
            'chart_data'=>$data,
        ];

        $response = $this->post('chart-testing',['options' => $options])->assertSuccessful();

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }

    /** @test  */
    function generate_a_donut_pie()
    {
        $data = collect([['name'=>'maria','ventas'=>97], ['name'=>'Jose','ventas'=>23], ['name'=>'carlos','ventas'=>97], ['name'=>'pedro','ventas'=>33], ['name'=>'marlon','ventas'=>95],]);

        $options = [
            'chart_name' => 'Donut Chart',
            'chart_type' => 'Pie & Donut',
            'chart_subtype' => 'Donut',
            'field_category' => 'name',
            'field_value' => 'ventas',
            'chart_data'=>$data,
        ];

        $response = $this->post('chart-testing',['options' => $options])->assertSuccessful();

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }

    /** @test  */
    function a_chart_required_a_field_category()
    {
        $data = collect([['name'=>'maria','ventas'=>97], ['name'=>'Jose','ventas'=>23], ['name'=>'carlos','ventas'=>97], ['name'=>'pedro','ventas'=>33], ['name'=>'marlon','ventas'=>95],]);
        $options = [
            'chart_name' => 'Donut Chart',
            'chart_type' => 'Pie & Donut',
            'chart_subtype' => 'Donut',
            'field_category' => '',
            'field_value' => 'ventas',
            'chart_data'=>$data,
        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing',['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {
            $this->assertSame('Charts Reports options validator: please specify field_category option', $e->getMessage());
            $this->assertSame(422, $e->getCode());

        }
    }

    /** @test  */
    function a_chart_required_a_field_value()
    {
        $data = collect([['name'=>'maria','ventas'=>97], ['name'=>'Jose','ventas'=>23], ['name'=>'carlos','ventas'=>97], ['name'=>'pedro','ventas'=>33], ['name'=>'marlon','ventas'=>95],]);

        $options = [
            'chart_name' => 'Donut Chart',
            'chart_type' => 'Pie & Donut',
            'chart_subtype' => 'Donut',
            'field_category' => 'name',
            'field_value' => '',
            'chart_data'=>$data,
        ];

        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing',['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify field_value option', $e->getMessage());

            $this->assertSame(422, $e->getCode());
        }
    }

    /** @test  */
    function generate_a_chart_dragging_pie_plices()
    {
        $data = collect([['name'=>'maria','ventas'=>97], ['name'=>'Jose','ventas'=>23], ['name'=>'carlos','ventas'=>97], ['name'=>'pedro','ventas'=>33], ['name'=>'marlon','ventas'=>95],]);

        $options = [
            'chart_name' => 'Dragging Pie Slices',
            'chart_type' => 'Pie & Donut',
            'chart_subtype' => 'Dragging Pie Slices',
            'field_category' => 'name',
            'field_value' => 'sales',
            'chart_data'=> $data,
        ];

        $response = $this->post('chart-testing',['options' => $options])->assertSuccessful();

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }

}