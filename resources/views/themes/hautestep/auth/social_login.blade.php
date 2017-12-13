@extends($theme_path.'.layouts.main',['request' => $request])
@section("title_tag")
<title> Login | {{ $config_data->website_title }}</title>
@stop
@section('content')
<section class="body-cnt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <form name="social_form" id="social_form">
                    <div class="singup-frm">
                        <div class='text-center'>
                            <h4>login your fashion account. It's free and only take a minute</h4>
                        </div>
                        <div class="form-group">
                            <label for="email"></label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-md pull-left"> Login </button>
                        </div>
                        <div class="height5"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop
@section('scripts')
<script type='text/javascript' src='{{ ThemeHelper::js("custom/auth/login") }}'></script>
@stop