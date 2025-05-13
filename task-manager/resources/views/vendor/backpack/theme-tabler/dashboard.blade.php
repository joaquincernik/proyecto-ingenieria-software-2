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

@section('content')
<h1>HOLAAA</h1>
@endsection

@section('after_content_widgets')
  @include(backpack_view('inc.widgets'), ['widgets' => app('widgets')->where('section', 'after_content')->toArray()])
@endsection