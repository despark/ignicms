<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Despark Website Administration - @yield('pageTitle', 'Home') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}" media="screen" charset="utf-8">

    <meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />

    @stack('additionalStyles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper">

        @include('admin.layouts.defaultMainHeader')

        @include('admin.layouts.sidebar')

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @if ($notification = session()->get('notification'))
                    <div class="alert alert-{{ array_get($notification, 'type') }} alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4>{{ array_get($notification, 'title') }}</h4>
                        {{ array_get($notification, 'description') }}
                    </div>
                @endif

                <!-- <h1>
                    @yield('contentHeaderTitle', 'Despark Website Administration')
                    <small>@yield('contentHeaderDescription')</small>
                </h1> -->
            </section>

            <section class="content">
                @yield('content')
            </section>
        </div>

        @include('admin.layouts.defaultFooter')

    </div>

    <script src="{{ asset('/js/admin.js') }}" type="text/javascript"></script>
    @stack('additionalScripts')

</body>
</html>
