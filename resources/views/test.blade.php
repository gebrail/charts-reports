<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Charts!</title>
    {!! $chart->renderChartLibrary() !!}
    {!! $chart->renderJs() !!}
</head>
<body>
<h1>{{ $chart->options['chart_name'] }}</h1>
{!! $chart->renderHtml() !!}
</body>
</html>
