@include($theme_path.'.emails.template.header') 
<!-- center part starts here-->

    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
        <b> Hello, </b> {{ $userObj->full_name() }},
    <div style="height:20px"></div>
    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">

Welcome to the "Who Needs Fashion".

    </p>
    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
        Your account has been successfully created. 
    </p>
    <div style="border-top:2px solid #ccc;"></div>
    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
        Please click on the link below to confirm your account
    </p>
    <div style="height:20px"></div>
    <div>
        <a class="btn" href="{{ url("confirm-account/".$userObj->signup_activation_key) }}">
           Confirmation Link

        </a>
    </div>
    
    @include($theme_path.'.emails.template.footer') 