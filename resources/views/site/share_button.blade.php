@section('share-styles')
<link rel="stylesheet" href="{{ ViewsHelper::css('plugins/share/jssocials') }}">
<link rel="stylesheet" href="{{ ViewsHelper::css('plugins/share/jssocials-theme-flat') }}">
@stop
@section('share-scripts')
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/share/jssocials.min') }}"></script>
<script>
var url = "http://google.com";
var text = "Some text to share";
$(".shareAdaptive").jsSocials({
url: $(this).attr("data-url"),
text: $(this).attr("data-text"),
shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"]
});
</script>
@stop