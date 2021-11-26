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
        $bibliotecas_amcharts= '<script src="https://cdn.amcharts.com/lib/5/index.js"></script> 
                                 <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                                 <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
                                 <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>';
        $this->assertEquals($bibliotecas_amcharts,$chart->renderChartLibrary());

    }


}