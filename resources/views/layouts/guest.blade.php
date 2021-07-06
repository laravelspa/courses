<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', $settings ? $settings->name : 'اسم المعهد') }}</title> --}}
    <title>{{ $settings ? $settings->name : 'Welcome' }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{ asset('plugins/fontawesome-free/css/all.min.css') }}>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href={{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}>
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset('css/adminlte.min.css') }}>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@php
$pageClass = '';
$pages = ['login', 'register', 'password.request', 'password.email', 'password.reset', 'password.confirm'];
@endphp

<body class="hold-transition {{ $pageClass }}login-page">
    <div class="{{ $pageClass }}login-box col-11 col-sm-8 col-lg-5 col-xl-4 col-xxl-3" style="width:auto">
        <div class="{{ $pageClass }}login-logo">
            <div style="width:33px" class="d-inline-block">
                <x-application-logo></x-application-logo>
            </div>
            {{ $settings ? $settings->name : 'اسم المعهد' }}</b></a>
        </div>

        {{ $slot }}

    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- jQuery -->
    <script src={{ asset('plugins/jquery/jquery.min.js') }}></script>
    <!-- Bootstrap 4 -->
    <script src={{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}></script>
</body>

</html>
