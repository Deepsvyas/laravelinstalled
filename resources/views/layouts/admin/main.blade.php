<!doctype html>
<html lang="en">
    <head>
        @include('layouts.admin.meta_css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('layouts.admin.constants_js')
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include('layouts.admin.header',['request' => $request])
            @include('layouts.admin.side_bar',['request' => $request])
            <div class="content-wrapper">
                @include('layouts.admin.heading_crumb')
                @yield('content')
            </div>
            @include('layouts.admin.control_side_bar')
            @include('layouts.admin.footer')
        </div>
        @include('layouts.admin.scripts')
    </body>
</html>