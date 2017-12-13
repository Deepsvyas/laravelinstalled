@include($theme_path.'.emails.template.header') 
<!-- center part starts here-->

    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;"><strong>Hello </strong> {{ $messageObj->toUser->first_name }},</p>
    
    <div style="height:20px"></div>
    <p>
        You a new message from {{ $messageObj->fromUser->first_name() }}
    </p>
    <div style="height:20px"></div>
    
    {!! CommonHelper::htmldata($messageObj->message) !!}
    
    
    @include($theme_path.'.emails.template.footer') 