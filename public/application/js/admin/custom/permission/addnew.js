$(document).ready(function(){
   
    $("#addNewPermissionFrm").submit(function(e){
        e.preventDefault();
        commonfn.doAjax({
                    url:ADMIN_HTTP_PATH+'permission/addnewajax',
                    dataString: $("#addNewPermissionFrm").serialize(),
                    elem:"#submitFrm",
                    ajaxSuccess:function(data)
                    {
                        if(data.error)
                        {
                            error_display(data.error_mess);
                        }
                        else
                        {
                            msg_alert(data.success_mess,ADMIN_HTTP_PATH+"permission");
                        }
                    }
                });
    });
    
});