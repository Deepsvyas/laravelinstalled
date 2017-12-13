<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.admin.meta_css')
        @include('layouts.admin.constants_js')
        @yield('styles')
    </head>
    <body class="hold-transition login-page">
        <div class="container-fluid">
            @yield('content')
        </div>        
        @include('layouts.admin.scripts')
    </body>
</html>