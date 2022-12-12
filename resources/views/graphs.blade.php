@if ($options['chart_type'] == 'Column & Bar')
    @if ($options['chart_subtype'] == 'simple column')
        <!-- Chart code -->
        <script>
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("{{ $options['chart_name'] ?? 'chartdiv' }}");

                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,
                    wheelX: "panX",
                    wheelY: "zoomX"
                }));

                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                    behavior: "zoomX"
                }));
                cursor.lineY.set("visible", false);

                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
                    maxDeviation: 0,
                    baseInterval: {
                        timeUnit: "{{ $options['chart_time'] ?? 'day' }}",
                        count: 1
                    },
                    renderer: am5xy.AxisRendererX.new(root, {}),
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));

                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "{{ $options['categoryYField']}}",
                    @if(isset($options['parse_date']))
                    valueXField: "{{ $options['categoryXField']}}_date",
                    @else
                    valueXField: "{{ $options['categoryXField']}}",
                    @endif
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                }));

                // Add scrollbar
                // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
                chart.set("scrollbarX", am5.Scrollbar.new(root, {
                    orientation: "horizontal"
                }));

                // Set data
                var data = @foreach ($datasets as $data) {!! $data !!}@endforeach;
                series.data.setAll(data);
                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear(1000);
                chart.appear(1000, 100);
            }); // end am5.ready()
        </script>
    @endif
    @if($options['chart_subtype'] == 'column with rotated labels')
        <!-- Chart code -->
        <script>
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("{{ $options['chart_name'] ?? 'chartdiv' }}");


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX"
                }));

                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineY.set("visible", false);


                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
                xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                });

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "{{ $options['categoryXField']}}",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


                // Create series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series 1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "{{ $options['categoryYField']}}",
                    sequencedInterpolation: true,
                    categoryXField: "{{ $options['categoryXField']}}",
                    tooltip: am5.Tooltip.new(root, {
                        labelText:"{valueY}"
                    })
                }));

                series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
                series.columns.template.adapters.add("fill", (fill, target) => {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", (stroke, target) => {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });


                // Set data
                var data =@foreach ($datasets as $data)
                        {!!$data!!}
                        @endforeach;

                xAxis.data.setAll(data);
                series.data.setAll(data);


                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear(1000);
                chart.appear(1000, 100);

                var exporting = am5plugins_exporting.Exporting.new(root, {
                    menu: am5plugins_exporting.ExportingMenu.new(root, {
                        container: document.getElementById("exportdiv")
                    }),
                    dataSource: data
                });

                exporting.events.on("dataprocessed", function(ev) {
                    for(var i = 0; i < ev.data.length; i++) {
                        ev.data[i].sum = ev.data[i].value + ev.data[i].value2;
                    }
                });

            }); // end am5.ready()

        </script>
    @endif
    @if($options['chart_subtype'] == 'clustered column')
        <!-- Chart code -->
        <script>
            am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("{{ $options['chart_name'] ?? 'chartdiv' }}");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    layout: root.verticalLayout
                }));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50
                    })
                );

                // Set data
                var data =@foreach ($datasets as $data)
                        {!!$data!!}
                        @endforeach;


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "{{ $options['field_category']}}",
                    renderer: am5xy.AxisRendererX.new(root, {
                        cellStartLocation: 0.1,
                        cellEndLocation: 0.9
                    }),
                    tooltip: am5.Tooltip.new(root, {})
                }));

                xAxis.data.setAll(data);

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                function makeSeries(name, fieldName) {
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: fieldName,
                        categoryXField: "{{ $options['field_category']}}"
                    }));

                    series.columns.template.setAll({
                        tooltipText: "{name}, {categoryX}:{valueY}",
                        width: am5.percent(90),
                        tooltipY: 0
                    });

                    series.data.setAll(data);

                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear();

                    series.bullets.push(function () {
                        return am5.Bullet.new(root, {
                            locationY: 0,
                            sprite: am5.Label.new(root, {
                                text: "{valueY}",
                                fill: root.interfaceColors.get("alternativeText"),
                                centerY: 0,
                                centerX: am5.p50,
                                populateText: true
                            })
                        });
                    });

                    legend.data.push(series);
                }

                @foreach ($options['columns_cluster'] as $column_cluster)
                makeSeries("{!! ucfirst($column_cluster) !!}", "{!! $column_cluster !!}");
                @endforeach


                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                chart.appear(1000, 100);

            }); // end am5.ready()
        </script>
    @endif
@endif
@if ($options['chart_type'] == 'Pie & Donut')
    @if ($options['chart_subtype'] == 'simple pie')
        <!-- Chart code -->
        <script>
            am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("{{ $options['chart_name'] ?? 'chartdiv' }}");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                var chart = root.container.children.push(am5percent.PieChart.new(root, {
                    layout: root.verticalLayout
                }));


// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                var series = chart.series.push(am5percent.PieSeries.new(root, {
                    valueField: "{{ $options['field_value']}}",
                    categoryField: "{{ $options['field_category']}}"
                }));
// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                var data = @foreach ($datasets as $data) {!! $data !!}@endforeach;
                series.data.setAll(data);


// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                series.appear(1000, 100);

            }); // end am5.ready()
        </script>
    @elseif($options['chart_subtype'] == 'donut')
        <!-- Chart code -->
        <script>
            am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("{{ $options['chart_name'] ?? 'chartdiv' }}");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                var chart = root.container.children.push(am5percent.PieChart.new(root, {
                    layout: root.verticalLayout,
                    innerRadius: am5.percent(50)
                }));


// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                var series = chart.series.push(am5percent.PieSeries.new(root, {
                    valueField: "{{ $options['field_value']}}",
                    categoryField: "{{ $options['field_category']}}",
                    alignLabels: false
                }));

                series.labels.template.setAll({
                    textType: "circular",
                    centerX: 0,
                    centerY: 0
                });


// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                var data = @foreach ($datasets as $data) {!! $data !!}@endforeach;
                series.data.setAll(data);


// Create legend
// https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
                var legend = chart.children.push(am5.Legend.new(root, {
                    centerX: am5.percent(50),
                    x: am5.percent(50),
                    marginTop: 15,
                    marginBottom: 15,
                }));

                legend.data.setAll(series.dataItems);


// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                series.appear(1000, 100);

            }); // end am5.ready()
        </script>
    @elseif($options['chart_subtype'] == 'dragging pie slices')
        <!-- Chart code -->
        <script>

            am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("{{ $options['chart_name'] ?? 'chartdiv' }}");

// Create custom theme
// https://www.amcharts.com/docs/v5/concepts/themes/#Quick_custom_theme
                var myTheme = am5.Theme.new(root);
                myTheme.rule("Label").set("fontSize", "0.8em");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root),
                    myTheme
                ]);

// Create wrapper container
                var container = root.container.children.push(am5.Container.new(root, {
                    width: am5.p100,
                    height: am5.p100,
                    layout: root.horizontalLayout
                }));

// Create first chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                var chart0 = container.children.push(am5percent.PieChart.new(root, {
                    innerRadius: am5.p50,
                    tooltip: am5.Tooltip.new(root, {})
                }));

// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                var series0 = chart0.series.push(am5percent.PieSeries.new(root, {
                    valueField: "{{ $options['field_value']}}",
                    categoryField: "{{ $options['field_category']}}",
                    alignLabels: false
                }));

                series0.labels.template.setAll({
                    textType: "circular",
                    templateField: "dummyLabelSettings"
                });

                series0.ticks.template.set("forceHidden", true);

                var sliceTemplate0 = series0.slices.template;
                sliceTemplate0.setAll({
                    draggable: true,
                    templateField: "settings",
                    cornerRadius: 5
                });

// Separator line
                container.children.push(am5.Line.new(root, {
                    layer: 1,
                    height: am5.percent(60),
                    y: am5.p50,
                    centerY: am5.p50,
                    strokeDasharray: [4, 4],
                    stroke: root.interfaceColors.get("alternativeBackground"),
                    strokeOpacity: 0.5
                }));

// Label
                container.children.push(am5.Label.new(root, {
                    layer: 1,
                    text: "Drag slices over the line",
                    y: am5.p50,
                    textAlign: "center",
                    rotation: -90,
                    isMeasured: false
                }));

// Create second chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                var chart1 = container.children.push(am5percent.PieChart.new(root, {
                    innerRadius: am5.p50,
                    tooltip: am5.Tooltip.new(root, {})
                }));

// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                var series1 = chart1.series.push(am5percent.PieSeries.new(root, {
                    valueField: "{{ $options['field_value']}}",
                    categoryField: "{{ $options['field_category']}}",
                    alignLabels: false
                }));

                series1.labels.template.setAll({
                    textType: "circular",
                    radius: 20,
                    templateField: "dummyLabelSettings"
                });

                series1.ticks.template.set("forceHidden", true);

                var sliceTemplate1 = series1.slices.template;
                sliceTemplate1.setAll({
                    draggable: true,
                    templateField: "settings",
                    cornerRadius: 5
                });

                var previousDownSlice;

// change layers when down
                sliceTemplate0.events.on("pointerdown", function (e) {
                    if (previousDownSlice) {
                        //  previousDownSlice.set("layer", 0);
                    }
                    e.target.set("layer", 1);
                    previousDownSlice = e.target;
                });

                sliceTemplate1.events.on("pointerdown", function (e) {
                    if (previousDownSlice) {
                        // previousDownSlice.set("layer", 0);
                    }
                    e.target.set("layer", 1);
                    previousDownSlice = e.target;
                });

// when released, do all the magic
                sliceTemplate0.events.on("pointerup", function (e) {
                    series0.hideTooltip();
                    series1.hideTooltip();

                    var slice = e.target;
                    if (slice.x() > container.width() / 4) {
                        var index = series0.slices.indexOf(slice);
                        slice.dataItem.hide();

                        var series1DataItem = series1.dataItems[index];
                        series1DataItem.show();
                        series1DataItem.get("slice").setAll({ x: 0, y: 0 });

                        handleDummy(series0);
                        handleDummy(series1);
                    } else {
                        slice.animate({
                            key: "x",
                            to: 0,
                            duration: 500,
                            easing: am5.ease.out(am5.ease.cubic)
                        });
                        slice.animate({
                            key: "y",
                            to: 0,
                            duration: 500,
                            easing: am5.ease.out(am5.ease.cubic)
                        });
                    }
                });

                sliceTemplate1.events.on("pointerup", function (e) {
                    var slice = e.target;

                    series0.hideTooltip();
                    series1.hideTooltip();

                    if (slice.x() < container.width() / 4) {
                        var index = series1.slices.indexOf(slice);
                        slice.dataItem.hide();

                        var series0DataItem = series0.dataItems[index];
                        series0DataItem.show();
                        series0DataItem.get("slice").setAll({ x: 0, y: 0 });

                        handleDummy(series0);
                        handleDummy(series1);
                    } else {
                        slice.animate({
                            key: "x",
                            to: 0,
                            duration: 500,
                            easing: am5.ease.out(am5.ease.cubic)
                        });
                        slice.animate({
                            key: "y",
                            to: 0,
                            duration: 500,
                            easing: am5.ease.out(am5.ease.cubic)
                        });
                    }
                });

// data
                var data = [
                    {
                        category: "Dummy",
                        value: 1000,
                        settings: {
                            fill: am5.color(0xdadada),
                            stroke: am5.color(0xdadada),
                            fillOpacity: 0.3,
                            strokeDasharray: [4, 4],
                            tooltipText: null,
                            draggable: false
                        },
                        dummyLabelSettings: {
                            forceHidden: true
                        }
                    },@foreach($datasets[0] as $data)
                            {!!  json_encode($data); !!},
                            @endforeach
                ];

// show/hide dummy slice depending if there are other visible slices
                function handleDummy(series) {
                    // count visible data items
                    var visibleCount = 0;
                    am5.array.each(series.dataItems, function (dataItem) {
                        if (!dataItem.isHidden()) {
                            visibleCount++;
                        }
                    });
                    // if all hidden, show dummy
                    if (visibleCount == 0) {
                        series.dataItems[0].show();
                    } else {
                        series.dataItems[0].hide();
                    }
                }
// set data
                series0.data.setAll(data);
                series1.data.setAll(data);

// hide all except dummy
                am5.array.each(series1.dataItems, function (dataItem) {
                    if (dataItem.get("category") != "Dummy") {
                        dataItem.hide(0);
                    }
                });

// hide dummy
                series0.dataItems[0].hide(0);

// reveal container
                container.appear(1000, 100);

            }); // end am5.ready()
        </script>
        @endif
    @endif
@if ($options['chart_type'] == 'Line & Area')
    @if($options['chart_subtype'] == 'date based data')
        <!-- Chart code -->
        <script>
            am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("{{ $options['chart_name'] ?? 'chartdiv' }}");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                root.dateFormatter.setAll({
                    dateFormat: "yyyy",
                    dateFields: ["valueX"]
                });

                var data =@foreach ($datasets as $data)
                        {!!$data!!}
                        @endforeach;


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    focusable: true,
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX"
                }));

                var easing = am5.ease.linear;


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
                    maxDeviation: 0.1,
                    groupData: false,
                    baseInterval: {
                        timeUnit: "day",
                        count: 1
                    },
                    renderer: am5xy.AxisRendererX.new(root, {

                    }),
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.2,
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.LineSeries.new(root, {
                    minBulletDistance: 10,
                    connect: false,
                    xAxis: xAxis,
                    yAxis: yAxis,
                    @if(isset($options['parse_date']))
                    valueXField: "{{ $options['categoryXField']}}_date",
                    @else
                    valueXField: "{{ $options['categoryXField']}}",
                    @endif
                    valueYField: "{{ $options['categoryYField']}}",
                    tooltip: am5.Tooltip.new(root, {
                        pointerOrientation: "horizontal",
                        labelText: "{valueY}"
                    })
                }));

                series.fills.template.setAll({
                    fillOpacity: 0.2,
                    visible: true
                });

                series.strokes.template.setAll({
                    strokeWidth: 2
                });


// Set up data processor to parse string dates
// https://www.amcharts.com/docs/v5/concepts/data/#Pre_processing_data
                series.data.processor = am5.DataProcessor.new(root, {
                    dateFormat: "yyyy-MM-dd",
                    @if(isset($options['parse_date']))
                    dateFields: ["{{ $options['categoryXField']}}_date"]
                    @else
                    dateFields: ["{{ $options['categoryXField']}}"]
                    @endif

                });

                series.data.setAll(data);

                series.bullets.push(function() {
                    var circle = am5.Circle.new(root, {
                        radius: 4,
                        fill: root.interfaceColors.get("background"),
                        stroke: series.get("fill"),
                        strokeWidth: 2
                    })

                    return am5.Bullet.new(root, {
                        sprite: circle
                    })
                });


// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                    xAxis: xAxis,
                    behavior: "none"
                }));
                cursor.lineY.set("visible", false);

// add scrollbar
                chart.set("scrollbarX", am5.Scrollbar.new(root, {
                    orientation: "horizontal"
                }));


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
                chart.appear(1000, 100);

            }); // end am5.ready()
        </script>
    @endif
@endif