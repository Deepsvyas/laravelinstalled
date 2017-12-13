@extends($theme_path.'.layouts.main',['request' => $request])
@section("title_tag")
<title> Reset Password | {{ $config_data->website_title }}</title>
@stop
@section('content')
<section class="body-cnt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <form  name="resetpassform" id="resetpassform">
                    <div class="singup-frm">
                        <div class='text-center'>
                            <h4> Reset Password </h4>
                        </div>
                        <div class="form-group">
                            <label for="new_password"></label>
                            <input class="form-control" placeholder="New Password" value="" name="new_password" id="new_password" type="password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password"></label>
                            <input class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" type="password">
                        </div>
                        <div class="form-group">
                            <button type="submit" id="resetpassword" name="resetpassword" class="btn btn-primary btn-md pull-left">Reset </button>
                        </div>
                        <div class="height5"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop
@section("scripts")
<script>
    var token = "<?php echo $token; ?>";
</script>
<script type="text/javascript" src="{{ ThemeHelper::js('custom/auth/reset_pass_form') }}"></script>
@stop