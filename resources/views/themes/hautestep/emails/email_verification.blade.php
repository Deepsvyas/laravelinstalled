@include($theme_path.'.emails.template.header') 
<!-- center part starts here-->
<p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
    {!! trans('emails.email_verification.title', ['user_email' => $userObj->email ]) !!}
</p>

<div style="height:20px"></div>
<p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
    {{ trans('emails.email_verification.heading') }}
</p>
<p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
    {{ trans('emails.email_verification.confirmation_link_content') }}
</p>
<div style="height:20px"></div>
<div>
    <a class="btn" style="background-color: #00AEE0; padding: 10px 20px;color:#FFF;text-decoration: none;" href="{{ url("confirm-account/".$userObj->signup_activation_key) }}">
        {{ trans('emails.email_verification.confirmation_link') }}
    </a>
</div>
@include($theme_path.'.emails.template.footer') 