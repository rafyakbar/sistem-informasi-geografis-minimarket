<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Bootstrap & carbon -->
    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carbon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @stack('css')
</head>
<body class="header-fixed">
    <div class="page-wrapper">
	
        @include('layouts.carbon.header')

        <div class="main-container">

            <div class="content">

                @yield('content')
            </div>

        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/carbon.js') }}"></script>
    @stack('js')
</body>
</html>
