<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>{{ ViewsHelper::getConfigKeyData('website_title') ." | ".$title }}</title>
        <style type="text/css">
            .ReadMsgBody {width: 100%; background-color: #ffffff;}
            .ExternalClass {width: 100%; background-color: #ffffff;}
            body     {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Arial, Helvetica, sans-serif}
            table {border-collapse: collapse;}
            @media only screen and (max-width: 640px)  {
                body[yahoo] .deviceWidth {width:440px!important; padding:0;}    
                body[yahoo] .center {text-align: center!important;}  
            }

            @media only screen and (max-width: 479px) {
                body[yahoo] .deviceWidth {width:280px!important; padding:0;}    
                body[yahoo] .center {text-align: center!important;}  
            }
            
            .table-top{
                border: 1px solid #e1dfdb; margin: 0 auto;
            }
            .webite_title{
                background-color: #00AEE0;padding: 20px;
            }
            .text-center{
                text-align: center;
            }
            .webite_title a{
                color: #FFF;text-decoration: none;
            }
            .wrapper20{
                padding:20px;
            }
            .p-class
            {
                color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; margin: 0 0 .75em 0;
            }
            .btn
            {
                background-color: #00AEE0; padding: 10px 20px;color:#FFF;text-decoration: none;
            }
        </style>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    </head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family:Arial, Helvetica, sans-serif;width:100%;background-color:#ffffff;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;-webkit-font-smoothing:antialiased;" >
        <!-- Wrapper -->

        <table bgcolor="#f9f8f4" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse:collapse;" >
            <tr>
                <td height="40" width="100%"></td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="600" style="margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;border-collapse:collapse;" >
                        <tr>
                            <td width="100%">
                                <table align="center" bgcolor="#ffffff" class="table-top" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;border-width:1px;border-style:solid;border-color:#e1dfdb;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" >
                                    <tr>
                                        <td>
                                            <div class="webite_title" style="background-color:#00AEE0;padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;" >
                                                <table  border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;" >
                                                    <tr>
                                                        <td class="text-center" style="text-align:center;" >
                                                            <a title="{{ ViewsHelper::getConfigKeyData('website_title') }}" href="{{url('/') }}" style="color:#FFF;text-decoration:none;" >
                                                                {{ ViewsHelper::getConfigKeyData('website_title') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div style="height:10px;" ></div>
                                            <div class="wrapper20" style="padding:20px;">