<!doctype html>
<html>
    <head>
        <title>@yield('title', 'Home') | Despark</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="Description" content="@yield('social:description', 'Despark')">
        <meta name="keywords" content="@yield('meta:keywords')">
        <link rel="canonical" href="{{ URL::current() }}" />

        <!-- for Facebook -->
        <meta property="og:title" content="@yield('social:title', 'Despark') | Despark" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="@yield('social:image', asset('/img/logo_600_350.jpg'))" />
        <meta property="og:url" content="{{ URL::current() }}" />
        <meta property="og:description" content="@yield('social:description', 'Despark')" />
        <meta property="fb:app_id" content="437670326442440" />

        <!-- for Twitter -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="@yield('social:title', 'Despark')" />
        <meta name="twitter:description" content="@yield('social:description', 'Despark')" />
        <meta name="twitter:image" content="@yield('social:image', asset('/images/logo-desktop.png'))" />

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('images/ico/favicon.png') }}">
        <!-- Icons -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('/images/ico/apple-touch-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('/images/ico/apple-touch-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('/images/ico/apple-touch-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/images/ico/apple-touch-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('/images/ico/apple-touch-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/images/ico/apple-touch-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('/images/ico/apple-touch-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/images/ico/apple-touch-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/ico/apple-touch-icon-180x180.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('/images/ico/favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('/images/ico/favicon-194x194.png') }}" sizes="194x194">
        <link rel="icon" type="image/png" href="{{ asset('/images/ico/favicon-96x96.png') }}" sizes="96x96">
        <link rel="icon" type="image/png" href="{{ asset('/images/ico/android-chrome-192x192.png') }}" sizes="192x192">
        <link rel="icon" type="image/png" href="{{ asset('/images/ico/favicon-16x16.png') }}" sizes="16x16">
        <link rel="manifest" href="{{ asset('/images/ico/manifest.json') }}">
        <link rel="shortcut icon" href="{{ asset('/images/ico/favicon.ico') }}">
        <meta name="msapplication-TileColor" content="#ffc40d">
        <meta name="msapplication-TileImage" content="{{ asset('/images/ico/mstile-144x144.png') }}">
        <meta name="msapplication-config" content="{{ asset('/images/ico/browserconfig.xml') }}">
        <meta name="theme-color" content="#ffffff">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link media="all" type="text/css" rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>

    <body>

        @include('ignicms::layouts.defaultHeader')

        @yield('content')

        @include('ignicms::layouts.defaultFooter')

        <script type="text/javascript">
            var currentRoute = '{{ Route::currentRouteName() }}';
        </script>
        <script type="text/javascript" src="{{ asset('js/vendors.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
