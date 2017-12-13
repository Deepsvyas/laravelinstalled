@extends('layouts.admin.login',['request' => $request])

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="container">
                    <div class="headline">
                        <h3>{{ trans('auth.reset_pass') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="divide40"></div>
                    <div class="clearfix"></div>

                    <div class="main-content clearfix">
                        <div class="divide30"></div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="panel panel-info">
                                    <div class="divide30"></div>
                                    <form  name="resetpassform" id="resetpassform" method="post">
                                        <div class="row">
                                            <div class="site-form col-md-offset-2 col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label" for="new_password">{{ trans('auth.labels.new_pass') }}</label>
                                                    <input type="password" class="form-control " id="new_password" name="new_password" placeholder="New Password" value="" />
                                                </div>
                                                <div class="form-group paswrd">
                                                    <label class="control-label" for="confirm_password">{{ trans('auth.labels.conf_pass') }}</label>
                                                    <input type="password" class="form-control " id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="" />

                                                </div>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input class="pull-left btn btn-info newpassword col-xs-12" type="submit" name="resetpassword" id="resetpassword" value="Reset" />
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="divide30"></div>
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


@section("scripts")
<script>
    var token = "<?php echo $token; ?>";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/auth/reset_pass_form') }}"></script>
@stop