<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        @vite('resources/scss/app.scss')
    </head>
    <body class="">
        @include('layouts.guest_navbar')
        <div class="container">

            {{ $slot }}

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
        {{-- Scripts --}}
        @vite('resources/js/app.js')
        <script src="{{ asset('js/masonry.js') }}"></script>
    </body>
</html>
