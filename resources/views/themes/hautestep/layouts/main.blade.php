<!DOCTYPE html>
<html lang="en">
    <head>
        @yield('title_tag')
        @include($theme_path.".layouts.meta_css")
        <script>
            var HTTP_PATH = "<?php echo url('/'); ?>";
            HTTP_PATH = HTTP_PATH+"/";
        </script>
    </head>
    <body>
        <div class="box-wide">
            <!-- Header -->
            @include($theme_path.".layouts.header")
            @yield("content")
            @include($theme_path.".layouts.footer")
        </div>
        @include($theme_path.".layouts.scripts")
    </body>
</html>