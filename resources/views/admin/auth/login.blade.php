@extends('layouts.admin.login',['request'=>$request])
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href=""><b>{{ Config::get("params.site_name") }}</b></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body" id="login_div_frm">
        <p class="login-box-msg">Sign in to start your session</p>
        <div class="callout callout-danger" id="login_error" style="display: none;"></div>
        <form method="post" name="loginFrm" id="loginFrm"  >
            @if($errors->any())
            <div class="callout callout-danger">
                <ul class="" id="rep_mess_w">
                    {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                </ul>
            </div>
            @endif 
            <div class="form-group has-feedback">
                <input type="email" class="form-control" name="sEmail" id="sEmail" placeholder="Email" />
                <span class="fa fa-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="sPassword" id="sPassword" placeholder="Password"/>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <a href="#" id="forgot_password">I forgot my password</a><br>
                </div>
                <div class="col-xs-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" name="submitFrm" id="submitFrm" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
        </form>

    </div><!-- /.login-box-body -->


    <!-- .forgot password body -->
    <div class="login-box-body displaynone" id="forgotpassword_frm">
        <p class="login-box-msg">Forgot Password? reset from here</p>
        <div class="callout callout-info">
            Enter your email address below. We'll look for your account and send you a password reset email.
        </div>
        <form method="post" name="forgotPasswordFrm" id="forgotPasswordFrm"  >
            <label for="forgotPasswordEmail"></label>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" name="forgotPasswordEmail" id="forgotPasswordEmail" placeholder="Email">
                <span class="fa fa-envelope form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <a href="#" id="backToLogin">Back To Login</a><br>
                </div>
                <div class="col-xs-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" name="submitForgotPasswordFrm" id="submitForgotPasswordFrm" class="btn btn-primary btn-block btn-flat">Reset</button>
                </div><!-- /.col -->
            </div>
        </form>
    </div><!-- /.<!-- .forgot password body --> 
</div><!-- .forgot password body -->

@stop


@section("scripts")
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/auth/login') }}"></script>
@stop