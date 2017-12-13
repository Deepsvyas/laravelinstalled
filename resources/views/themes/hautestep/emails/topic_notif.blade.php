@include($theme_path.'.emails.template.header') 
<p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
    <b> Hello, </b> {{ $userObj->full_name() }},
<div style="height:20px"></div>
<p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
    <b>{{ $commObj->user->full_name() }} </b>, reacted to your {{ $commObj->topic->topic }} Threads.
</p>
<div style="height:20px"></div>
<div style="height:20px"></div>
<p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
    {!! $commObj->comment !!}
</p>
@include($theme_path.'.emails.template.footer') 