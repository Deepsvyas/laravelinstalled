@include($theme_path.'.emails.template.header') 
<!-- center part starts here-->

    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
        <strong>Hello </strong> {{ $user_name }},</p>
    
    <div style="height:20px"></div>
    
    {!! CommonHelper::htmldata($newsletter->newsletter_content) !!}
    
    
    @include($theme_path.'.emails.template.footer') 