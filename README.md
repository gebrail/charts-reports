# Charts Reports
Paquete para generar gráficos con Amcharts directamente desde laravel, sin interactuar con JavaScript.

### Guia de inicio rapido

#### Pre-requisitos

No hay configuración adicional u otros parámetros todavía.
> 🔰 Este paquete se puede usar en **Laravel 7 o superior.**

### Instalación
Puedes instalar el paquete a través de composer

```bash
composer require gebrail/charts-reports
```

> 🔰 Este paquete tambien ofrece la opción de generar graficas con artisan, mediante la interfaz de línea de comandos que viene junto a Laravel.


## Guia rapida de como usar

### Ejemplo

Para crear su primer gráfico, diríjase a su controlador.
#### En su controlador agregue las siguientes lineas

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

#### Agregue las siguientes lineas a su vista

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

Para generar la gráfica debemos hacer el llamado de la función renderHtml(), podemos usarla en cualquier parte siempre que este dentro de la etiqueta body.

###Resultado

![](https://3156765290-files.gitbook.io/~/files/v0/b/gitbook-x-prod.appspot.com/o/spaces%2FvWJzDEJMsRQQEBckKtD8%2Fuploads%2FUtHsNMsshE4puV9J68CD%2FScreenshot%202022-06-06%20at%2022-47-21%20Donut%20chart%20.png?alt=media&token=0fe9ab4b-af13-4cac-9912-b3af125ec5b3)

###Graficas disponibles del paquete 

- Simple Pie Chart. 
- Donut Chart. 
- Dragging Pie Slices 
- Simple Column 
- Column with Rotated Labels. 
- Clustered Column Chart. 
- Line & Area

##📘[Ir a la Documentación](https://gebrail.gitbook.io/charts-reports/)

## License
[MIT](./LICENSE.md)
