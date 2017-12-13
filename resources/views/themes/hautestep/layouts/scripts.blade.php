<script src="{{ ThemeHelper::js('plugins') }}"></script>
<script type="text/javascript" src="{{ ThemeHelper::js('custom/app') }}"></script>
<script>
var is_online = 0;

@if(Auth::check())
      is_online = 1;
@endif
</script>
@yield('scripts')