@extends($theme_path.'.layouts.main',['request' => $request])
@section("title_tag")
<title> Signup | {{ $config_data->website_title }}</title>
@stop
@section('content')
<style>

    @media screen and (max-width: 376px) and (min-width: 320px){}
    .loginBtn {
        box-sizing: border-box;
        position: relative;
        margin: 0.1em;
        padding: 0 10px 0 44px;
        border: none;
        text-align: left;
        line-height: 34px;
        white-space: nowrap;
        border-radius: 0.2em;
        font-size: 16px;
        color: #FFF;
        width: 200px;
    }  
    .or-txt-case {
        position: relative;
        text-align: center;
        width: 100%!important;
        margin: 10px auto -5px;
    }
.joinus_heading{
    font-weight: bold;
    font-size: 24px;
    color: #4c69ba;
}
</style>
<section class="body-cnt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
                <div class="singup-frm">
                    <div class='text-center joinus_heading'>
                       {{ $page->page_heading }}
                    </div>
                    <div class='text-center'>
                        <h4>{!! CommonHelper::htmlData($page->page_content) !!}</h4>
                    </div>
                    <div class='text-center'>
                        <a class="btn btn-danger loginBtn loginBtn--google" href="{{ url('auth/google') }}">
                            <span class="social-btn">Google </span>
                        </a>	
                        <a class="btn btn-danger loginBtn loginBtn--facebook" href="{{ url('auth/facebook') }}">
                            <span class="social-btn"> Facebook </span>
                        </a>
                    </div>
                    <div class="or-txt-case"><span>OR</span></div>

                    <div class="height10"></div>
                    <div class="height5"></div>
                    <form name="signup_form" id="signup_form" novalidate="">
                        <div class="form-group">
                            <label for="first_name"></label>
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="last_name" ></label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label for="email"></label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email ">
                        </div>
                        <div class="form-group">
                            <label for="phone_number"></label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Phone Number">
                        </div>
                        <div class="form-group">
                            <label for="password"></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="conf_password"></label>
                            <input type="password" id="conf_password"  name="conf_password" class="form-control" placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <button type="submit" id="signupBtn" name="signupBtn" class="btn btn-primary btn-md pull-left">Sign Up</button>
                            <a class="pull-right linkmt20" href="{{ url('/login') }}">Log in </a>
                        </div>
                        <div class="height5"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('scripts')
<script type='text/javascript' src='{{ ThemeHelper::js("custom/auth/signup") }}'></script>
@stop