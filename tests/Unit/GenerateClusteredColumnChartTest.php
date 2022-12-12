<?php

use Gebrail\ChartsReports\Tests\TestCase;

class GenerateClusteredColumnChartTest extends TestCase
{
    /** @test  */
    function a_chart_required_a_field_category()
    {
        $data = collect(['date', 'value']);

        $data->combine([1637384400000,97],[1637470800000,93],[1637557200000,97]);

        $options = [
            'chart_name'=>'Clustered Column Chart',
            'chart_type'=>'Column & Bar',
            'chart_subtype'=>'Clustered Column Chart',
            'chart_data' => $data,
            'field_category'=>''
        ];

        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing',['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify field_category option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

        }
    }

    /** @test  */
    function a_chart_required_a_field_cluster()
    {
        $data = collect(['date', 'value']);

        $data->combine([1637384400000,97],[1637470800000,93],[1637557200000,97]);

        $options = [
            'chart_name' => 'Clustered Column Chart',
            'chart_type' => 'Column & Bar',
            'chart_subtype' => 'Clustered Column',
            'chart_data'=> $data,
            'field_category' =>'data',
            'columns_cluster'=>'',
        ];

        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing',['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify field_cluster option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

        }
    }

    /** @test  */
    function generate_a_chart_clustered()
    {
        $data = collect([
            ['year'=>2021, 'europe'=> 2.5, 'namerica'=> 2.5, 'asia'=> 2.1, 'lamerica'=> 1, 'meast'=> 0.8, 'africa'=> 0.4],
            ['year'=>2022, 'europe'=> 2.6, 'namerica'=> 2.7, 'asia'=> 2.2, 'lamerica'=> 0.5, 'meast'=> 0.4, 'africa'=> 0.3],
            ['year'=>2023,'europe'=> 2.8,'namerica'=> 2.9,'asia'=> 2.4,'lamerica'=> 0.3,'meast'=> 0.9,'africa'=> 0.5]]);

        $options = [
            'chart_name' => 'Clustered Column Chart',
            'chart_type' => 'Column & Bar',
            'chart_subtype' => 'Clustered Column',
            'chart_data'=> $data,
            'field_category' => 'year',
            'columns_cluster'=>['europe','namerica','asia','lamerica','meast','africa'],
        ];

        $response = $this->post('chart-testing',['options' => $options])->assertSuccessful();

        $response->assertOk();

        $response->assertViewIs('charts-reports::test');

    }
}