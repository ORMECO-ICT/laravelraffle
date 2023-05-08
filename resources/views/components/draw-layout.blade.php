<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#f20c49" />
        <meta name="mobile-web-app-capable" content="yes" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{asset('assets/img/raffle-logo_100x100.ico')}}">

        <!-- Scripts -->
        @vite(['resources/css/draw.css', 'resources/scss/draw.scss','resources/js/app.js','resources/js/draw.ts'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>

        {{ $slot }}

        @stack('modals')

        @livewireScripts
    </body>
</html>
