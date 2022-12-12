<?php

namespace Gebrail\ChartsReports\Tests\Unit;
use Gebrail\ChartsReports\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
class GeneratedChartByConsoleTest extends TestCase
{

    /** @test */
    public function comando_para_generara_grafica_de_columna_simple()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
            'Name for the graph?',
            // When answered with "sales of the year"
            'sales of the year'
        )->expectsQuestion(
            'What type of Graph do you want to use?'."\n".' 1 - Column & Bar.'."\n".' 2 - Line & Area.'."\n".' 3 - Pie & Donut. ',
            // When answered with "1"
            '1'
        )->expectsQuestion(
            '- Column & Bar Options:'."\n".' 1 - Simple Column Chart.'."\n".' 2 - Column With Rotated Labels.'."\n".' 3 - Clustered column chart. ',
            // When answered with "1"
            '1'
        )->expectsQuestion(
            'field name for X axis?',
            // When answered with "seller"
            'seller'
        )->expectsQuestion(
            'field name for Y axis',
            // When answered with "sales"
            'sales'
        )->expectsQuestion(
            'name of the variable with the data, which you are going to use. (Example posts)',
            // When answered with "transactions"
            'transactions'
        )->expectsOutput('SimpleColumn chart.html file is published.')
            ->expectsOutput('Graph Column & Bar created correctly')
            ->assertExitCode(0);
    }
    /** @test */
    public function comando_para_generara_grafica_de_columna_con_etiquetas()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?'."\n".' 1 - Column & Bar.'."\n".' 2 - Line & Area.'."\n".' 3 - Pie & Donut. ',
                // When answered with "1"
                '1'
            )->expectsQuestion(
                '- Column & Bar Options:'."\n".' 1 - Simple Column Chart.'."\n".' 2 - Column With Rotated Labels.'."\n".' 3 - Clustered column chart. ',
                // When answered with "1"
                '2'
            )->expectsQuestion(
                'field name for X axis? (Example name [$users->name])',
                // When answered with "name"
                'name'
            )->expectsQuestion(
                'field name for Y axis (Example sales) [$users->sales]',
                // When answered with "sales"
                'sales'
            )->expectsQuestion(
                'name of the variable with the data, which you are going to use. (Example $users)',
                // When answered with "users"
                'users'
            )->expectsOutput('ColumnWithRotatedLabels chart.html file is published.')
            ->expectsOutput('Graph Column & Bar created correctly')
            ->assertExitCode(0);
    }
    /** @test */
    public function comando_para_generara_grafica_de_columnas_agrupadas()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?'."\n".' 1 - Column & Bar.'."\n".' 2 - Line & Area.'."\n".' 3 - Pie & Donut. ',
                // When answered with "1"
                '1'
            )->expectsQuestion(
                '- Column & Bar Options:'."\n".' 1 - Simple Column Chart.'."\n".' 2 - Column With Rotated Labels.'."\n".' 3 - Clustered column chart. ',
                // When answered with "1"
                '3'
            )->expectsQuestion(
                'grouping category name (Example year [$markets->year])',
                // When answered with "name"
                'name'
            )->expectsQuestion(
                "columns you want to work with (example ['europe','namerica','asia','lamerica','meast','africa'])",
                // When answered with "['europe','namerica','asia','lamerica','meast','africa']"
                "['europe','namerica','asia','lamerica','meast','africa']"
            )->expectsQuestion(
                'name of the variable with the data, which you are going to use. (Example $markets)',
                // When answered with "$markets"
                '$markets'
            )->expectsOutput('ClusteredColumn chart.html file is published.')
            ->expectsOutput('Graph Column & Bar created correctly')
            ->assertExitCode(0);
    }
    /** @test */
    public function comando_para_generara_grafica_de_lineas_area()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?'."\n".' 1 - Column & Bar.'."\n".' 2 - Line & Area.'."\n".' 3 - Pie & Donut. ',
                // When answered with "1"
                '2'
            )->expectsQuestion(
                '- Line & Area:'."\n".'1- Date Based Data.'."\n",
                // When answered with "1"
                '1'
            )->expectsQuestion(
                'field name for X axis?',
                // When answered with "name"
                'name'
            )->expectsQuestion(
                'field name for Y axis',
                // When answered with sales
                'sales'
            )->expectsQuestion(
                '- Parse dates?'."\n".'¿yes or no?'."\n",
                // When answered with "$markets"
                'no'
            )->expectsQuestion(
                'name of the variable with the data, which you are going to use. (Example posts)',
                // When answered with "$transactions"
                'transactions'
            )->expectsOutput('DateBasedData chart.html file is published.')
            ->expectsOutput('Date Based Data created correctly')
            ->assertExitCode(0);
    }
    /** @test */
    public function comando_para_generara_grafica_circular_pie_simple()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?'."\n".' 1 - Column & Bar.'."\n".' 2 - Line & Area.'."\n".' 3 - Pie & Donut. ',
                // When answered with "1"
                '3'
            )->expectsQuestion(
                '- Pie & Donut:'."\n".'1- Simple Pie Chart.'."\n".'2- Donut chart.'."\n".'3- Dragging Pie Slices',
                // When answered with "1"
                '1'
            )->expectsQuestion(
                'categorized field name (example : name)',
                // When answered with "name"
                'name'
            )->expectsQuestion(
                'categorized field value name (example : sales)',
                // When answered with sales
                'sales'
            )->expectsQuestion(
                'name of the variable with the data, which you are going to use. (Example users)',
                // When answered with "$users"
                '$users'
            )->expectsOutput('Pie chart.html file is published.')
            ->expectsOutput('Graph Pie & Donut created correctly')
            ->assertExitCode(0);
    }
    /** @test */
    public function comando_para_generara_grafica_circular_dona()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?' . "\n" . ' 1 - Column & Bar.' . "\n" . ' 2 - Line & Area.' . "\n" . ' 3 - Pie & Donut. ',
                // When answered with "1"
                '3'
            )->expectsQuestion(
                '- Pie & Donut:' . "\n" . '1- Simple Pie Chart.' . "\n" . '2- Donut chart.' . "\n" . '3- Dragging Pie Slices',
                // When answered with "1"
                '2'
            )->expectsQuestion(
                'categorized field name (example : name)',
                // When answered with "name"
                'name'
            )->expectsQuestion(
                'categorized field value name (example : sales)',
                // When answered with sales
                'sales'
            )->expectsQuestion(
                'name of the variable with the data, which you are going to use. (Example users)',
                // When answered with "$users"
                '$users'
            )->expectsOutput('Pie chart.html file is published.')
            ->expectsOutput('Graph Pie & Donut created correctly')
            ->assertExitCode(0);
        }
    /** @test */
    public function comando_para_generara_grafica_donas_arrastrables()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?' . "\n" . ' 1 - Column & Bar.' . "\n" . ' 2 - Line & Area.' . "\n" . ' 3 - Pie & Donut. ',
                // When answered with "1"
                '3'
            )->expectsQuestion(
                '- Pie & Donut:' . "\n" . '1- Simple Pie Chart.' . "\n" . '2- Donut chart.' . "\n" . '3- Dragging Pie Slices',
                // When answered with "1"
                '3'
            )->expectsQuestion(
                'categorized field name (example : name)',
                // When answered with "name"
                'name'
            )->expectsQuestion(
                'categorized field value name (example : sales)',
                // When answered with sales
                'sales'
            )->expectsQuestion(
                'name of the variable with the data, which you are going to use. (Example users)',
                // When answered with "$users"
                '$users'
            )->expectsOutput('Pie chart.html file is published.')
            ->expectsOutput('Graph Pie & Donut created correctly')
            ->assertExitCode(0);
    }
    /** @test */
    public function error_al_no_seleccionar_el_tipo_de_grafica()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?' . "\n" . ' 1 - Column & Bar.' . "\n" . ' 2 - Line & Area.' . "\n" . ' 3 - Pie & Donut. ',
                // When answered with "8"
                '8'
            )->assertExitCode(0);
    }
    /** @test */
    public function error_al_no_seleccionar_el_subtipo_de_grafica_pie()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?' . "\n" . ' 1 - Column & Bar.' . "\n" . ' 2 - Line & Area.' . "\n" . ' 3 - Pie & Donut. ',
                // When answered with "8"
                '3'
            )->expectsQuestion(
                '- Pie & Donut:' . "\n" . '1- Simple Pie Chart.' . "\n" . '2- Donut chart.' . "\n" . '3- Dragging Pie Slices',
                // When answered with "6"
                '6'
            )->assertExitCode(0);
        }
    /** @test */
    public function error_al_no_seleccionar_el_subtipo_de_grafica_lineal()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?' . "\n" . ' 1 - Column & Bar.' . "\n" . ' 2 - Line & Area.' . "\n" . ' 3 - Pie & Donut. ',
                // When answered with "8"
                '2'
            )->expectsQuestion(
                '- Line & Area:'."\n".'1- Date Based Data.'."\n",
                // When answered with "6"
                '6'
            )->assertExitCode(0);
    }
    /** @test */
    public function error_al_no_seleccionar_el_subtipo_de_grafica_columnas()
    {
        // nos asegúramos de que estamos comenzando desde un estado limpio
        $this->artisan('make:chart-report')
            ->expectsQuestion(
                'Name for the graph?',
                // When answered with "sales of the year"
                'sales of the year'
            )->expectsQuestion(
                'What type of Graph do you want to use?' . "\n" . ' 1 - Column & Bar.' . "\n" . ' 2 - Line & Area.' . "\n" . ' 3 - Pie & Donut. ',
                // When answered with "8"
                '1'
            )->expectsQuestion(
                '- Column & Bar Options:'."\n".' 1 - Simple Column Chart.'."\n".' 2 - Column With Rotated Labels.'."\n".' 3 - Clustered column chart. ',
                // When answered with "6"
                '6'
            )->assertExitCode(0);
    }
}