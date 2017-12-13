@extends('layouts.admin.login',['request' => $request])

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="container">
                    <div class="headline">
                        <h3>Reset Password</h3>
                    </div>
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
                                            <div id="password_reset_success_show" class="callout callout-danger">
                                                <i class="fa fa-times"></i> Token is not valid or has been expired.
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
    </div>
    <!-- /.row -->
</section>
@stop


<!-- End Content Part -->