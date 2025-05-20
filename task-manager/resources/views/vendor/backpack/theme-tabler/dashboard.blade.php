@extends(backpack_view('layouts.' . (backpack_theme_config('layout') ?? 'vertical')))

@section('before_breadcrumbs_widgets')
    @include(backpack_view('inc.widgets'), ['widgets' => app('widgets')->where('section', 'before_breadcrumbs')->toArray()])
@endsection

@section('after_breadcrumbs_widgets')
    @include(backpack_view('inc.widgets'), ['widgets' => app('widgets')->where('section', 'after_breadcrumbs')->toArray()])
@endsection

@section('before_content_widgets')
    @include(backpack_view('inc.widgets'), ['widgets' => app('widgets')->where('section', 'before_content')->toArray()])
@endsection


@php
    $cantidadTareas = \App\Models\Tarea::count();
    $cantidadUsuarios = \App\Models\User::count();
    $cantidadProyectos = \App\Models\Proyecto::count();
    $cantidadCategorias = \App\Models\Categoria::count();

    $cantidadTareasNoRealizadas = \App\Models\Tarea::where('estado', 1)->count();
    $cantidadTareasEnProceso = \App\Models\Tarea::where('estado', 2)->count();
    $cantidadTareasFinalizadas = \App\Models\Tarea::where('estado', 3)->count();

    $cantidadTareasPrioridadBaja = \App\Models\Tarea::where('prioridad', 1)->count();
    $cantidadTareasPrioridadMedia = \App\Models\Tarea::where('prioridad', 2)->count();
    $cantidadTareasPrioridadAlta = \App\Models\Tarea::where('prioridad', 3)->count();

@endphp
@section('content')
    <div class="row row-cards mb-5">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Usuarios</div>
                    </div>
                    <div class="h1 mb-3">{{ $cantidadUsuarios }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Tareas</div>
                    </div>
                    <div class="h1 mb-3">{{ $cantidadTareas }}</div>

                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Proyectos</div>
                    </div>
                    <div class="h1 mb-3">{{ $cantidadProyectos }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Categorias</div>
                    </div>
                    <div class="h1 mb-3">{{$cantidadCategorias}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body py-4">
            <h1 class="text-center p-3">Estado de tareas</h1>
            <div id="chart-demo-pie" class="position-relative pb-5"></div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body py-5">
            <h1 class="text-center p-3">Prioridad de tareas</h1>
            <div class="d-flex">
                <div id="chart-progress" class="position-relative col-4 "></div>
                <div id="chart-progress-mid" class="position-relative col-4 "></div>
                <div id="chart-progress-high" class="position-relative col-4 "></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>

        //grafico de torta
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-pie'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 400,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: true
                    },
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toFixed(2) + "%"
                    },
                },

                series: [{{ $cantidadTareasNoRealizadas }}, {{ $cantidadTareasEnProceso }}, {{ $cantidadTareasFinalizadas }}],
                labels: ["No realizada", "En proceso", "Finalizadas"],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    strokeDashArray: 3,
                },
                colors: [
                    'rgba(255,99,132,0.8)', 'rgba(255,206,86,0.8)', 'rgba(75, 192, 192, 0.8)'
                ],
                legend: {
                    show: true,
                    position: 'bottom',
                    fontFamily: "inherit",
                    offsetY: 12,
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 100,
                    },
                    itemMargin: {
                        horizontal: 8,
                        vertical: 8
                    },
                    labels: {
                        colors: 'rgba(255, 255, 255)',
                    }
                },
                tooltip: {
                    fillSeriesColor: false
                },
            })).render();

            //grafico de progreso bajo
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-progress'), {
                chart: {
                    type: "radialBar",
                    fontFamily: 'inherit',
                    height: 400,
                    animations: {
                        enabled: true
                    },
                },
                series: [{{ $cantidadTareasPrioridadBaja / $cantidadTareas * 100 }}],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: "80%",
                        },

                        dataLabels: {
                            showOn: "always",
                            name: {
                                offsetY: -10,
                                show: true,
                                color: "white",
                                fontSize: "16px"
                            },
                            value: {
                                color: "#888",
                                fontSize: "30px",
                                show: true,
                                formatter: function (val) {
                                    return val.toFixed(2) + "%";
                                },

                            }
                        }
                    }
                },
                stroke: {
                    lineCap: "round",
                },
                colors: ["#20E647"],
                labels: ["Tareas con prioridad baja"]

            }
            )).render();

            //grafico de progreso media
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-progress-mid'), {
                chart: {
                    type: "radialBar",
                    fontFamily: 'inherit',
                    height: 400,
                    animations: {
                        enabled: true
                    },
                },
                series: [{{ $cantidadTareasPrioridadMedia / $cantidadTareas * 100 }}],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: "80%",
                        },

                        dataLabels: {
                            showOn: "always",
                            name: {
                                offsetY: -10,
                                show: true,
                                color: "white",
                                fontSize: "16px"
                            },
                            value: {
                                color: "#888",
                                fontSize: "30px",
                                show: true,
                                formatter: function (val) {
                                    return val.toFixed(2) + "%";
                                },

                            }
                        }
                    }
                },
                stroke: {
                    lineCap: "round",
                },
                colors: ["#E6E620"],
                labels: ["Tareas con prioridad media"]

            }
            )).render();

            //grafico de progreso alta
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-progress-high'), {
                chart: {
                    type: "radialBar",
                    fontFamily: 'inherit',
                    height: 400,
                    animations: {
                        enabled: true
                    },
                },
                series: [({{ $cantidadTareasPrioridadAlta / $cantidadTareas }}) * 100],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: "80%",
                        },

                        dataLabels: {
                            showOn: "always",
                            name: {
                                offsetY: -10,
                                show: true,
                                color: "white",
                                fontSize: "16px"
                            },
                            value: {
                                color: "#888",
                                fontSize: "30px",
                                show: true,
                                formatter: function (val) {
                                    return val.toFixed(2) + "%";
                                },

                            }
                        }
                    }
                },
                stroke: {
                    lineCap: "round",
                },
                colors: ["#E62020"],
                labels: ["Tareas con prioridad alta"]

            }
            )).render();
        });
    </script>

@endsection

@section('after_content_widgets')
    @include(backpack_view('inc.widgets'), ['widgets' => app('widgets')->where('section', 'after_content')->toArray()])
@endsection