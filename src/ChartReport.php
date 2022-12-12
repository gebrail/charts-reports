<?php

namespace Gebrail\ChartsReports;

use Gebrail\ChartsReports\Repositories\ChartReportRepositories;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChartReport extends ChartReportRepositories
{
    public $options     = [];
    private $datasets   = [];

    /**
     * ChartsReports constructor.
    * @throws \Exception
    */
    public function __construct()
    {
        foreach (func_get_args() as $arg) {

            $this->options = $arg;

            $this->options['chart_name'] = strtolower(Str::slug($arg['chart_name'], '_'));

            $this->options['chart_subtype'] = strtolower($arg['chart_subtype']);

            $this->datasets[] = $this->prepareData();
        }
    }


    /**
     * @return array
     * @throws \Exception
     */
    private function prepareData()
    {
        $this->validateOptions($this->options);
        $dataset=[];
            if (count($this->options['chart_data']))
            {
                if($this->options['chart_subtype']=='simple column')
                {
                    if(isset($this->options['parse_date'])=='yes')
                    {
                        $dataset= ChartReportRepositories::parse_date_simple_chart($this->options);
                    }
                    else
                    {
                        $dataset=$this->options['chart_data'];
                    }
                }
                if($this->options['chart_subtype']=='column with rotated labels')
                {
                    return $this->options['chart_data'];
                }
                if($this->options['chart_subtype']=='date based data')
                {
                    if(isset($this->options['parse_date']) &&  $this->options['parse_date']=='yes')
                    {
                       $dataset= ChartReportRepositories::parse_date_based_data_chart($this->options);
                    }
                    else
                    {
                        return $this->options['chart_data'];
                    }
                }
                if($this->options['chart_subtype'] == 'clustered column')
                {
                    return $this->options['chart_data'];
                }
                if($this->options['chart_subtype']=='simple pie' || $this->options['chart_subtype']=='donut' || $this->options['chart_subtype']=='dragging pie slices')
                {
                    return $this->options['chart_data'];
                }
            }
        return $dataset;
    }

    public function  renderChartLibrary()
    {
        return '<script src="https://cdn.amcharts.com/lib/5/index.js"></script> 
                                 <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                                 <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
                                 <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>';
    }

    public function renderExport()
    {
        return '<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>';
    }

    /**
     * @throws \Exception
     */
    private function validateOptions($options)
    {
        $this->validate_chart_principal($options);

        $this->validate_chart_attributes($options);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderJs()
    {
        return view('charts-reports::graphs', ['options' => $this->options,'datasets' => $this->datasets]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderHtml()
    {
        return view('charts-reports::html', ['options' => $this->options]);
    }
}