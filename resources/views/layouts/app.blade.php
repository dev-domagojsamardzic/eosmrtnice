<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @filamentStyles
    @vite(['resources/scss/app.scss'])
</head>

{{-- New layout --}}
<body class="sidebar-toggled" id="page-top">

<div id="wrapper">
    <!-- Sidebar -->
    @include(auth_user_type() . '.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- TopBar -->
        <div id="content">

            <!-- Main Content -->
            @include('layouts.navigation')
            <!-- End of TopBar -->

            <!-- Begin Page Content -->
            <div class="container-fluid" style="position: relative">

                <!-- Page Heading -->
                @if (isset($header))
                    <h1 class="h3 mb-4 text-gray-800">{{ $header }}</h1>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Boostrap alert -->
        @if(session()->has('alert'))
            @php
                $flash = session('alert')
            @endphp
            <div id="flash_alert"
                 class="alert alert-absolute-flex align-items-center alert-{{ $flash['class'] }} fade show"
                 role="alert">
                <div class="d-flex justify-content-start align-items-center gap-3">
                    @include('svg.icons.' . $flash['class'])
                    {{ $flash['message'] }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- Scripts -->
@vite(['resources/js/app.js'])
@filamentScripts
@stack('scripts')
</body>
{{-- New layout end --}}
</html>
