<?php

namespace Gebrail\ChartsReports\Console;

use Illuminate\Console\Command;

class ChartsReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:chart-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new graph report or implement it on your dashboard';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $chart_name= $this->ask('Name for the graph?');

        $type_graph= $this->ask('What type of Graph do you want to use?'."\n".' 1 - Column & Bar.'."\n".' 2 - Line & Area.'."\n".' 3 - Pie & Donut. ');

         switch ($type_graph) {
            case 1:
                $chart_subtype= $this->ask('- Column & Bar Options:'."\n".' 1 - Simple Column Chart.'."\n".' 2 - Column With Rotated Labels.'."\n".' 3 - Clustered column chart. ');

                if($chart_subtype==="1"||$chart_subtype==="2"||$chart_subtype==="3")
                {
                    if($chart_subtype==="1")
                    {
                        $categoryXField=$this->ask('field name for X axis?');

                        $categoryYField=$this->ask('field name for Y axis');

                        $chart_data=$this->ask('name of the variable with the data, which you are going to use. (Example posts)');

                        $options= [
                            'chart_name' => $chart_name,
                            'chart_type' => 'Column & Bar',
                            'chart_subtype' => 'Simple Column',
                            'categoryXField' => $categoryXField,
                            'categoryYField' => $categoryYField,
                            'chart_time' => 'day',
                            'chart_data'=> $chart_data,
                        ];

                        $template_stub='SimpleColumn';
                        $this->generate_chart($options, $template_stub);

                    }
                    elseif($chart_subtype==="2")
                    {
                        $categoryXField=$this->ask('field name for X axis? (Example name [$users->name])');

                        $categoryYField=$this->ask('field name for Y axis (Example sales) [$users->sales]');

                        $chart_data=$this->ask('name of the variable with the data, which you are going to use. (Example $users)');

                        $options= [
                            'chart_name' => $chart_name,
                            'chart_type' => 'Column & Bar',
                            'chart_subtype' => 'Column With Rotated Labels',
                            'categoryXField' => $categoryXField,
                            'categoryYField' => $categoryYField,
                            'chart_data'=>$chart_data,
                        ];
                        $template_stub='ColumnWithRotatedLabels';
                        $this->generate_chart($options, $template_stub);

                    }
                    elseif ($chart_subtype==="3")
                    {
                        $field_category=$this->ask('grouping category name (Example year [$markets->year])');

                        $columns_cluster=$this->ask("columns you want to work with (example ['europe','namerica','asia','lamerica','meast','africa'])");

                        $chart_data=$this->ask('name of the variable with the data, which you are going to use. (Example $markets)');

                        $options= [
                            'chart_name' => $chart_name,
                            'chart_type' => 'Column & Bar',
                            'chart_subtype' => 'Clustered Column',
                            'chart_data'=> $chart_data,
                            'field_category' => $field_category,
                            'columns_cluster'=>$columns_cluster,
                        ];

                        $template_stub='ClusteredColumn';

                        $this->generate_chart($options, $template_stub);

                    }
                    $this->info('Graph Column & Bar created correctly');
                    break;
                }
                else
                {
                    $this->error('Something went wrong!');
                    break;
                }
            case 2:
                $type_la = $this->ask('- Line & Area:'."\n".'1- Date Based Data.'."\n");
                if($type_la ==='1')
                {
                    $categoryXField=$this->ask('field name for X axis?');

                    $categoryYField=$this->ask('field name for Y axis');

                    $parse_date=$this->ask('- Parse dates?'."\n".'¿yes or no?'."\n");

                    $chart_data=$this->ask('name of the variable with the data, which you are going to use. (Example posts)');

                    $options= [
                        'chart_name' => $chart_name,
                        'chart_type' => 'Line & Area',
                        'chart_subtype' => 'Date Based Data',
                        'categoryXField' => $categoryXField,
                        'categoryYField' => $categoryYField,
                        'parse_date'=>$parse_date,
                        'chart_data'=> $chart_data,
                    ];

                    $template_stub='DateBasedData';

                    $this->generate_chart($options, $template_stub);

                    $this->info('Date Based Data created correctly');

                    break;
                }
                else
                {
                    $this->error('Something went wrong!');
                    break;
                }
            case 3:
            $type_pd = $this->ask('- Pie & Donut:'."\n".'1- Simple Pie Chart.'."\n".'2- Donut chart.'."\n".'3- Dragging Pie Slices');
            if($type_pd==="1" || $type_pd==="2" || $type_pd==="3")
            {
                $field_category= $this->ask('categorized field name (example : name)');

                $field_value=$this->ask('categorized field value name (example : sales)');

                $chart_data=$this->ask('name of the variable with the data, which you are going to use. (Example users)');

                $options= [
                    'chart_name' => $chart_name,
                    'chart_type' => 'Pie & Donut',
                    'chart_subtype' => 'X',
                    'field_category' => $field_category,
                    'field_value' => $field_value,
                    'chart_data'=> $chart_data,
                ];

                $template_stub='Pie';
                if($type_pd==="1")
                {
                    $options['chart_subtype']='Simple Pie';
                    $this->generate_chart($options, $template_stub);

                }
                elseif($type_pd==="2")
                {
                    $options['chart_subtype']='Donut';
                    $this->generate_chart($options, $template_stub);
                }
                elseif($type_pd==="3")
                {
                    $options['chart_subtype']='DraggingPieSlices';
                    $this->generate_chart($options, $template_stub);
                }
                $this->info('Graph Pie & Donut created correctly');
                break;
            }
            else
            {
                $this->error('Something went wrong!');
                break;
            }
            default:
             $this->error('Something went wrong!');
             break;
        }
        return Command::SUCCESS;
    }


    public static function createFile($path, $fileName, $contents)
    {
        $path = $path.$fileName;

        file_put_contents($path, $contents);
    }


    protected function generate_chart($options,$template_stub)
    {
        $publicDir = public_path();

        $TemplateChart = $this->getStubContents($options, $template_stub);

        $this->createFile($publicDir. DIRECTORY_SEPARATOR, 'chart.html', $TemplateChart);

        $this->info($template_stub.' chart.html file is published.');

    }

    protected function getStubContents($stubVariables = [],$template_stub)
    {
        $contents = $this->getStub($template_stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('{{'.$search.'}}' , $replace, $contents);
        }
        return $contents;
    }

    protected function getStub($template_stub)
    {
        return file_get_contents(__DIR__.'/stubs/'.$template_stub.'.stub');
    }

}