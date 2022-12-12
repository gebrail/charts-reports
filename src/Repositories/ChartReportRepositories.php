<?php

namespace Gebrail\ChartsReports\Repositories;

use Illuminate\Support\Facades\Validator;

class ChartReportRepositories
{
    protected  function validation_principal_attributes()
    {
        return [
            'chart_name'        => 'chart_name' ,
            'chart_type'        => 'chart_type' ,
            'chart_subtype'     => 'chart_subtype',
            'chart_data'        => 'chart_data' ,
        ];
    }

    protected function validation_principal_rules()
    {
        return [
            'chart_name'            => 'required',
            'chart_type'            => 'required|in:Column & Bar,Pie & Donut,Line & Area|bail',
            'chart_subtype'         => 'required',
            'chart_data'            => 'required',
        ];
    }

    protected function validation_principal_messages()
    {

        return [
            'required' => 'please specify :attribute option',
            'chart_type.in' => 'chart_type option should contain one of these values - Column & Bar / Pie & Donut / Line & Area',
            'chart_subtype' => 'chart_subtype Specify the chart subtype',
        ];

    }

    protected function rules_chart($sub_type)
    {
        $rules=[];
        switch ($sub_type) {
            case 'column with rotated labels':
                $rules = [
                    'categoryXField'        => 'required',
                    'categoryYField'        => 'required',
                ];
                break;
            case 'simple column':
                $rules = [
                    'categoryXField'        => 'required',
                    'categoryYField'        => 'required',
                    'chart_time'            => 'in:day,week,month,year|bail',
                ];
                break;
            case 'clustered column':
                $rules = [
                    'field_category'  => 'required',
                    'columns_cluster' => 'required',
                ];
                break;
            case 'dragging pie slices':
            case 'donut':
            case 'simple pie':
                $rules = [
                    'field_category'  => 'required',
                    'field_value' => 'required',
                ];
                break;
            case 'date based data':
                $rules = [
                    'categoryXField'        => 'required',
                    'categoryYField'        => 'required',
                    'parse_date'            => 'required',
                ];
                break;
        }
        return $rules;
    }

    protected function messages_chart($sub_type)
    {
        $messages = [];

        switch ($sub_type) {
            case 'simple column':
                $messages = [
                    'required' => 'please specify :attribute option',
                    'categoryXField' => 'specify the field name for variables on the X-axis',
                    'categoryYField' => 'specify the field name for variables on the Y-axis',
                    'chart_time.in' => 'chart_time option should contain one of these values - day,week/month/year',
                ];
                break;
            case 'column with rotated labels':
                $messages = [
                    'required' => 'please specify :attribute option',
                    'categoryXField' => 'specify the field name for variables on the X-axis',
                    'categoryYField' => 'specify the field name for variables on the Y-axis',
                ];
                break;
            case 'clustered column':
                $messages = [
                    'required' => 'please specify :attribute option',
                    'field_category'  => 'specify the field name for variable on category',
                    'columns_cluster' => 'specify the field name for variable cluster',
                ];
                break;
            case 'dragging pie slices':
            case 'simple pie':
            case 'donut':
                $messages = [
                    'required' => 'please specify :attribute option',
                    'field_category'  => 'specify the field name for variable on category',
                    'field_value' => 'specify the field name for variable cluster',
                ];
                break;
            case 'date based data':
                $messages = [
                    'required' => 'please specify :attribute option',
                    'categoryXField' => 'specify the field name for variables on the X-axis',
                    'categoryYField' => 'specify the field name for variables on the Y-axis',
                    'parse_date'     => 'you need to confirm parse the date,when the date is an instance of "Carbon"',
                ];
                break;
        }
        return $messages;
    }

    protected  function attributes_charts()
    {
        return [
            'categoryXField'    => 'categoryXField',
            'categoryYField'    => 'categoryYField',
            'chart_time'        => 'chart_time' ,
            'field_category'    => 'field_category',
            'columns_cluster'   => 'field_cluster',
            'field_value' => 'field_value',
            'parse_date' => 'parse_date',
        ];
    }

    protected function parse_date_simple_chart($options)
    {
        $collection = collect();

        foreach ($options['chart_data'] as $row)
        {
            $getacc = $row;

            $dateInterface = \Carbon\Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $row["{$options['categoryXField']}"]);

            $getacc["{$options['categoryXField']}_date"] = (int)((strtotime($dateInterface)) . "000");

            $collection->push($getacc);
        }
        return $collection;
    }

    protected function parse_date_based_data_chart($options)
    {
        $collection=collect();

        foreach ($options['chart_data'] as $row)

        {
            $getacc = $row;

            $getacc["{$options['categoryXField']}_date"] =  $row["{$options['categoryXField']}"]->toDateString(); ;

            $collection->push($getacc);
        }

        return $collection;
    }

    protected function validate_chart_principal($options)
    {
        $rules = $this->validation_principal_rules();

        $messages = $this->validation_principal_messages();

        $attributes = $this->validation_principal_attributes();

        $validator_principal= Validator::make($options, $rules, $messages, $attributes);

        if ($validator_principal->fails()) {
            throw new \Exception('Charts Reports options validator: ' . $validator_principal->errors()->first(),422);
        }
    }

     protected  function validate_chart_attributes($options)
    {
        $attributes =ChartReportRepositories::attributes_charts();

        $rules= ChartReportRepositories::rules_chart($options['chart_subtype']);

        $messages = ChartReportRepositories::messages_chart($options['chart_subtype']);

        $validator_chart = Validator::make($options, $rules, $messages, $attributes);

        if ($validator_chart->fails()) {
            throw new \Exception('Charts Reports options validator: ' . $validator_chart->errors()->first(),422);
        }
    }
}