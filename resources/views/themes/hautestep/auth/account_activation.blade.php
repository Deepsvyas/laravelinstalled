@extends($theme_path.'.layouts.main',['request' => $request])

@section("title_tag")
<title>{{ "Email Account Confirmation | ".$config_data->website_title }}</title>
@stop

@section('content')

<section class="body-cnt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="singup-frm">
                    @if(!$valid)
                    <div id="password_reset_success_show" class="">
                        Invalid token Please resend confrim mail
                    </div>
                    @elseif($valid)
                    <div id="password_reset_success_show" class="">
                        Account confirmed successfully
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@stop