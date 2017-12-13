@include($theme_path.'.emails.template.header') 
<!-- center part starts here-->

    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">{!! trans('emails.user_contect.title') !!}</p>
    
    <div style="height:20px"></div>
    
    <p class="p-class" style="color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;">
        {{ trans('emails.user_contact.regarding_details') }}
    </p>
    
    <table style="border: 1px solid #CCC;" class="userdata-table" cellpading="20" cellspacing="10">
        <tr>
            <th>Name</th>
            <td>{{ $input['full_name'] }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $input['email_id'] }}</td>
        </tr>
        <tr>
            <th>Company</th>
            <td>{{ $input['company'] }}</td>
        </tr>
        <tr>
            <th>Contact No.</th>
            <td>{{ $input['phone_num'] }}</td>
        </tr>
        <tr>
            <th>Skype Id</th>
            <td>{{ $input['skype_id'] }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $input['country_id'] or "--" }}</td>
        </tr>
        <tr>
            <th>Service Type</th>
            <td>{{ $input['service_type'] }}</td>
        </tr>
        <tr>
            <th>Service Description</th>
            <td>{{ $input['description'] }}</td>
        </tr>
    </table>
    
    
    @include($theme_path.'.emails.template.footer') 