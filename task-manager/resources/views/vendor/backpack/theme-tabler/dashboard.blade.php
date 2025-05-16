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
$cantidadCategorias = \App\Models\Categoria::count()

@endphp
@section('content')
<div class="row row-cards">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Usuarios</div>
                </div>
                <div class="h1 mb-3">{{ $cantidadUsuarios }}</div>
                <div class="d-flex mb-2">
                    <div class="text-green me-2">
                        4% <i class="ti ti-arrow-up-right"></i>
                    </div>
                    <div class="text-muted">Última semana</div>
                </div>
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
                <div class="d-flex mb-2">
                    <div class="text-red me-2">
                        -1% <i class="ti ti-arrow-down-right"></i>
                    </div>
                    <div class="text-muted">Última semana</div>
                </div>
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
                <div class="d-flex mb-2">
                    <div class="text-green me-2">
                        8% <i class="ti ti-arrow-up-right"></i>
                    </div>
                    <div class="text-muted">Última semana</div>
                </div>
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
                <div class="d-flex mb-2">
                    <div class="text-green me-2">
                        2% <i class="ti ti-arrow-up-right"></i>
                    </div>
                    <div class="text-muted">Última semana</div>
                </div>
            </div>
        </div>
    </div>
</div>@endsection

@section('after_content_widgets')
  @include(backpack_view('inc.widgets'), ['widgets' => app('widgets')->where('section', 'after_content')->toArray()])
@endsection