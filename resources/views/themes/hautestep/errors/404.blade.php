@extends($theme_path.'.layouts.main',['request' => $request])
@section("title_tag")
<title> 404 | {{ $config_data->website_title }}</title>
@stop
@section('content')
<div class="container">
    <div class="content abtt">
        <div class="title text-center"><b>404 Not found. </b>
            <br>
            The page you are looking does not found on our server
        </div>
    </div>
</div>
@stop
@section('styles')
<link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<style>
    .title {
        font-size: 30px;
        margin-bottom: 40px;
    }
	.abtt {
     max-height: 396px;
    background-color: white;
}
</style>
@stop
@section('scripts')
@stop