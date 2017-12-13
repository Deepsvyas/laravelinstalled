<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name='csrf-token' content='{{ csrf_token() }}'>
<link rel="stylesheet" href="{{ ThemeHelper::css('bootstrap.min') }}">
<link rel="stylesheet" href="{{ ThemeHelper::css('font-awesome.min') }}">
<link rel="stylesheet" href="{{ ThemeHelper::css('style') }}">
@yield("styles")