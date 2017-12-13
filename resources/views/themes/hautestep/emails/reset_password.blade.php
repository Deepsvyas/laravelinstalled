@include($theme_path.'.emails.template.header') 
<!-- center part starts here-->


<p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;"><b>Hello, </b>{{ $model->email }}</p>
    <div style="height:20px"></div>
    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
        Please Click on Reset button to generate New Password for your Account. Thanks.
    </p>
    <div style="height:20px"></div>
    
    <div style="border-top: 1px solid #eaeaea; height: 20px;"></div>
    <div style=" width: 120px;padding: 9px 16px 9px 16px; margin-top: 10px;margin-bottom: 10px; font-size: 16px; color: #F7FBFD; background: #0088CC;">
        <a moz-do-not-send="true" target="_blank" style="text-decoration: none;font-size: 16px; color: #F7FBFD;" href="{{ url('resetpassword/' . $model->reset_key) }}">
            <span style="color:#F7FBFD">Reset Password</span>

        </a>
    </div>
    @include($theme_path.'.emails.template.footer') 
    
    
    
                                    