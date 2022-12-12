<?php
namespace Gebrail\ChartsReports\Tests\Unit;
use Gebrail\ChartsReports\ChartReport;
use Gebrail\ChartsReports\Tests\TestCase;

class GenerateCharTest extends TestCase
{
    /** @test */
    public function retornar_las_bibliotecas_de_amcharts()
    {
        $chart = new ChartReport();

        $bibliotecas_amcharts = '<script src="https://cdn.amcharts.com/lib/5/index.js"></script> 
                                 <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                                 <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
                                 <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>';
        $this->assertEquals($bibliotecas_amcharts, $chart->renderChartLibrary());

    }

    /** @test */
    public function retornar_las_bibliotecas_de_amcharts_de_exportacion()
    {
        $chart = new ChartReport();
        $bibliotecas_amcharts_export = '<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>';
        $this->assertEquals($bibliotecas_amcharts_export, $chart->renderExport());
    }

    /** @test */
    function a_chart_require_a_name()
    {
        $options = [
            'chart_name' => '',
            'chart_type' => 'Column & Bar',
            'chart_subtype' => 'Simple Column',
        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing', ['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify chart_name option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

            return;
        }

    }

    /** @test */
    function a_chart_requiere_a_type()
    {
        $options = [
            'chart_name' => 'simple column',
            'chart_type' => '',
            'chart_subtype' => 'Simple Column',
        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing', ['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify chart_type option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

            return;
        }

    }

    /** @test */
    function a_chart_requiere_a_subtype()
    {
        $options = [
            'chart_name' => 'simple column',
            'chart_type' => 'Column & Bar',
            'chart_subtype' => ''

        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing', ['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify chart_subtype option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

            return;
        }
    }

    /** @test */
    function a_chart_requiere_a_data()
    {
        $options = [
            'chart_name' => 'Simple column',
            'chart_type' => 'Column & Bar',
            'chart_subtype' => 'Simple Column',
            'chart_data' => '',

        ];
        try {
            $response = $this->withoutExceptionHandling()->postJson('chart-testing', ['options' => $options])->assertSuccessful();
        } catch (\Exception $e) {

            $this->assertSame('Charts Reports options validator: please specify chart_data option', $e->getMessage());

            $this->assertSame(422, $e->getCode());

            return;
        }
    }


}