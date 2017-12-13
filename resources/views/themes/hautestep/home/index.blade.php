@extends($theme_path.'.layouts.main',['request' => $request]) 
@section("title_tag")
<title> Home | {{ $config_data->website_title }}</title>
@stop
@section('content')
<section class="text-center" style="height: 500px; margin-top:300px ">
    <h1> Home Pages of Hautestep </h1>
</section>
@stop
@section('styles')
@stop
@section('scripts')
@stop