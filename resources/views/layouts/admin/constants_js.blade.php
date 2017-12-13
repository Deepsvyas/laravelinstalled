<script>
    var HTTP_PATH = "{{url('/')}}/";
    var ADMIN_HTTP_PATH = "{{url('admin')}}/";
    <?php
    if(Auth::check())
    {
    ?>
    var USER_PATH = "{{url('userdata/'.Auth::user()->id_user.'/')}}";
    <?php
    }
    ?>
    var JS_PATH = "{{url('js')}}/";
    var IMG_PATH = "{{url('img')}}/";
    var ICONS_PATH = "{{url('img/icons')}}/";
</script>