<?php
namespace App\Helpers;
use Config, Auth;

class EmailTemplate {

    public static function defaultBtn($text, $link){
        
        return '<!-- Start: Grey button -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                        <tr>
                                            <td style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                                <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" style="padding-top:15px;padding-bottom:15px;padding-right:0;padding-left:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                                                <table border="0" cellpadding="0" cellspacing="0" width="130" style="border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                                                    <tr>
                                                                        <td align="center" width="130" class="button2" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;background-color:#999999;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;word-break:break-word;word-wrap:break-word;" >
                                                                        <a href="'.url($link).'" style="mso-line-height-rule:exactly;vertical-align:top;display:block;border-width:1px;padding-top:10px;padding-bottom:10px;padding-right:10px;padding-left:10px;font-family:Arial, sans-serif;font-size:14px;color:#ffffff;font-weight:bold;line-height:16px;text-decoration:none;text-align:center;background-color:#999999;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-style:solid;border-color:#999999;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;" >'.$text.'</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End: Grey button -->';
        
    }
    
    
    public static function primaryBtn($text, $link){
        
        return '<table width="98%" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                        <tr>
                            <td align="center" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                <table border="0" align="center" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                    <tbody>
                                        <tr>
                                            <td align="center" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                                <table border="0" cellpadding="0" cellspacing="0" style="width:130px;border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                                    <tr>
                                                        <td align="center" class="button1" style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;background-color:#45b1e2;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;word-break:break-word;word-wrap:break-word;" >

                                                            <a href="'.url($link).'" style="display:block;border-width:1px;padding-top:10px;padding-bottom:10px;padding-right:10px;padding-left:10px;font-family:Arial, sans-serif;font-size:14px;color:#ffffff;font-weight:bold;line-height:16px;text-decoration:none;text-align:center;background-color:#45b1e2;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-style:solid;border-color:#45b1e2;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;" >
                                                                '.$text.'
                                                            </a>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>';
        
    }
    
    public static function rssText($heading, $text, $link, $separate = true){
        
        $html = '<table border="0" cellspacing="0" cellpadding="0" align="center"  class="deviceWidth" style="width:480px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                <tr>
                    <td align="left" valign="top"  class="rssTitle titlePaddingForMobile" style="padding-top:15px;padding-bottom:0;padding-right:0;padding-left:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;font-family:Arial, sans-serif;font-size:16px;color:#20a2dc;font-weight:bold;line-height:20px;mso-line-height-rule:exactly;text-align:left;vertical-align:top;" >

                        <a href="'.url($link).'" style="color:#20a2dc;text-decoration:none;" >'.$heading.' </a></td>
                </tr>
                <tr>
                    <td align="left" valign="top"  class="bodyText textPaddingForMobile" style="padding-top:5px;padding-bottom:15px;padding-right:0;padding-left:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;color:#222222;font-family:Arial, sans-serif;font-size:14px;line-height:20px;mso-line-height-rule:exactly;vertical-align:top;text-decoration:none;" >

                        '.$text.'

                    </td>
                </tr>
            </table>';
        
        if($separate){
            $html .= '<table border="0" cellspacing="0" cellpadding="0" align="center"  class="deviceWidth" style="width:480px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                <tr>
                    <td height="1" style="font-size:1px;color:#ffffff;mso-line-height-rule:exactly;line-height:1px;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#cccccc;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >-</td>
                </tr>
            </table>';
        }
        
        return $html; 
    }
    
    public static function textPara($heading, $text, $link, $btn_text = false){
        
        $btn_text = ($btn_text) ?  EmailTemplate::primaryBtn($btn_text, $link) : '' ;
        return '<table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff"  class="deviceWidth" style="width:580px;border-spacing:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >
                                <tr>
                                    <td align="center" valign="top" bgcolor="#ffffff"  class="heading" style="padding-top:40px;padding-bottom:20px;padding-right:40px;padding-left:40px;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;font-family:Arial, sans-serif;font-size:26px;color:#45b1e2;font-weight:bold;line-height:26px;mso-line-height-rule:exactly;text-align:center;vertical-align:top;" >

                                        <a href="'.url($link).'" style="color:#45b1e2;text-decoration:none;" >
                                            '.$heading.'
                                        </a>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" bgcolor="#ffffff"  class="bodyText" style="padding-top:0;padding-bottom:15px;padding-right:45px;padding-left:45px;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;color:#222222;font-family:Arial, sans-serif;font-size:14px;line-height:20px;mso-line-height-rule:exactly;vertical-align:top;text-decoration:none;" >
                                    '.$text.'
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top:0;padding-bottom:40px;padding-right:0;padding-left:0;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;" >

                                        <!-- Start: Blue button -->
                                <center>

                                    '. $btn_text .' 

                                </center>
                                <!-- End: Blue button -->

                        </td>
                    </tr>
                </table>';
        
        
        
        
    }
    
}
