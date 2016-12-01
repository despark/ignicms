<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Despark Website Administration - @yield('pageTitle', 'Home') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @include('ignicms::admin.assets.css')
    @stack('additionalStyles')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    @include('ignicms::admin.layouts.defaultMainHeader')
    @include('ignicms::admin.layouts.sidebar')
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
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>
    @include('ignicms::admin.layouts.defaultFooter')
</div>
@include('ignicms::admin.assets.javascript')
@stack('additionalScripts')
</body>
</html>
