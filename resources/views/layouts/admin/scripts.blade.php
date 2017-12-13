<script type="text/javascript" src="{{ ViewsHelper::js('plugins/jquery-1.11.3') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/bootstrap.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/bootbox.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/admin.min') }}"></script>

@yield('scripts')
@yield('uploader_scripts')
<script>
            var app_js_message = {!! ViewsHelper::getAppJsMessages() !!};
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/app') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/jquery.data_table') }}"></script>
