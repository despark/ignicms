<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Despark Website Administration - @yield('pageTitle', 'Home') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}" media="screen" charset="utf-8">

    <meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @stack('additionalStyles')

</head>

<body class="login-page">
@yield('content')
</body>

@stack('additionalScripts')

</html>
