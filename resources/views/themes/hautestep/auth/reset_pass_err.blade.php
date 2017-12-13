@extends($theme_path.'.layouts.main',['request' => $request])
@section("title_tag")
<title>Reset Password | {{ $config_data->website_title }}</title>
@stop
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
                <div class="container">
                    <div class="clearfix"></div>
                    <div class="divide40"></div>
                    <div class="clearfix"></div>

                    <div class="main-content clearfix">
                        <div class="divide30"></div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="panel">
                                    <div class="divide30"></div>
                                    <div class="row">
                                        <div class="site-form col-md-offset-2 col-md-8">
                                            <div id="password_reset_success_show" class="bs-callout bs-callout-danger">
                                                <i class="fa fa-times"></i> {{ trans('auth.reset_pass_error') }}
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
    <!-- /.row -->
</section>
@stop


<!-- End Content Part -->