<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--CSRF Protection-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--Videojs-->
        <link href="http://vjs.zencdn.net/5.17.0/video-js.css" rel="stylesheet">
        <!-- If you'd like to support Video Player in IE8 -->
        <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
        <!--Snowflake Icons taken from https://icons8.com/-->
        <link rel="shortcut icon" href="/storage/icons/snowflake.png">
        <!--Font Awesome-->
        <script src="https://use.fontawesome.com/fffe030555.js"></script>
        <!--My Css File-->
        <link rel="stylesheet" href="/css/app.css">
        <!--Pusher-->
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        <title>Medeniyet Sosyal</title>
    </head>
    <body>
        <div class="navigation">
            @include('templates.partials.navigation')
        </div>
        @include('templates.partials.modals')
        <div class="container-fluid">
            @yield('header')
                @include('templates.partials.alerts')
                <a href="/feedback" class="link">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        <span>Pşşt! Şuan erken erişim aşamasındayız eğer bir terslik farkedersen bana tıkla ve geri bildirim gönder.</span>
                    </div>
                </a>
            @yield('content')
        </div>
        <!--app.js File-->
        <script src="/js/app.js"></script>
        <!--End of app.js File-->

        <script>
            //redirect to specific tab
            $(document).ready(function () {
                $('#tabs a[href="#{{ old('tab') }}"]').tab('show');
            });
        </script>
        <!--

            Background taken from,
            <a href="http://www.freepik.com/free-vector/beautiful-watercolor-background-with-splatters_1324341.htm">Designed by Freepik</a>

            Snowflake Icon
            <div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
        -->
    </body>
</html>
