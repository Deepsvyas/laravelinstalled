@extends($theme_path.'.layouts.main',['request' => $request])
@section("title_tag")
<title> Login | {{ $config_data->website_title }}</title>
@stop
@section('content')
<section class="body-cnt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <form name="signin_form" id="signin_form">
                    <div class="singup-frm">
                        <div class='text-center'>
                            <h4>login your fashion account. It's free and only take a minute</h4>
                        </div>
                        <div class='text-center'>
                            <a class="btn btn-danger loginBtn loginBtn--google" href="{{ url('auth/google') }}">
                                <span class="social-btn"> Google </span>
                            </a>	
                            <a class="btn btn-danger loginBtn loginBtn--facebook" href="{{ url('auth/facebook') }}">
                                <span class="social-btn"> Facebook </span>
                            </a>
                        </div>
                        <div class="height10"></div>
                        <div class="height5"></div>
                        <div class="form-group">
                            <label for="sEmail"></label>
                            <input type="text" id="sEmail" name="sEmail" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="sPassword"></label>
                            <input type="password" id="sPassword" name="sPassword" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-md pull-left">Login</button>
                            <a id="btnforgotpaswd"  class="pull-right forgot-link">Forgot Password? </a>
                        </div>

                        <div class="height20"></div>

                        <div class="or-txt-case"><span>OR</span></div>
                        <div class="height20"></div>

                        <div class='text-center'>
                            Create your account now
                            <div class='height5'></div>
                            <a class="" href="{{ url('/new-signup') }}">Create Account </a>
                        </div>
                        <div class="height5"></div>
                    </div>
                </form>
                <form class="displaynone" name="resetFrm" id="resetFrm">
                    <div class="singup-frm forgot-frm">
                        <h4>Forgot Password </h4>
                        <div class="form-group">
                            <label for="forgotPasswordEmail"></label>
                            <input type="text" name="forgotPasswordEmail" id="forgotPasswordEmail" class="form-control" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group pull-left">
                            <button type="submit" name="resetSubmitFrm" id="resetSubmitFrm" class="btn btn-primary btn-md"> Submit </button>
                            <a id="back_to_login" href="{{ url('login') }}"> Back to Login ? </a>
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
@if($request->input('frgps') != null)
<script>
        $("#resetFrm").slideDown(1000);
        $("#signin_form").slideUp(1000);
</script>
@endif
<script type='text/javascript' src='{{ ThemeHelper::js("custom/auth/login") }}'></script>
@stop