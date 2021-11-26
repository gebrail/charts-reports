# Charts Reports

Package to generate charts with Amcharts directly from laravel , without interacting with JavaScript.

## Installation

```bash
composer require gebrail/charts-reports
```

## Usage

### Example

#### In your controller

```PHP

$data = User::select(array('name', 'sales'))->take(3)->get();

 $options = [
              'chart_name' => 'Donut Chart',
              'chart_type' => 'Pie & Donut',    
              'chart_subtype' => 'Donut',
              'field_category' => 'name',
              'field_value' => 'sales',
              'chart_data'=> $data,
           ];
$chart = new ChartReport($options);

return view('graph', compact('chart'));

```

#### In your View

```HTML
<!doctype html>
<html lang="en">
  <head>
{!! $chart->renderChartLibrary() !!}
{!! $chart->renderJs() !!}
  </head>
  <body>
   {!! $chart->renderHtml() !!}
    </body>
</html>

```

![Imagen de prueba](https://www.amcharts.com/wp-content/uploads/2013/11/demo_129_none-1-1024x690.png "Estamos en fase beta")

