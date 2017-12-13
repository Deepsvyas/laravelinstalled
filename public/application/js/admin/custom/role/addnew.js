$(document).ready(function(){
   
    $("#addNewRoleFrm").submit(function(e){
        e.preventDefault();
        commonfn.doAjax({
                    url:ADMIN_HTTP_PATH+'role/addnewajax',
                    dataString: $("#addNewRoleFrm").serialize(),
                    elem:"#submitFrm",
                    ajaxSuccess:function(data)
                    {
                        if(data.error)
                        {
                            error_display(data.error_mess);
                        }
                        else
                        {
                            msg_alert(data.success_mess,ADMIN_HTTP_PATH+"role");
                        }
                    }
                });
    });
    
});