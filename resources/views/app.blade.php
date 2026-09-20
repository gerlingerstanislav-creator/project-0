<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon-96.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <title inertia>{{ $title ?? 'project-0 — инструменты' }}</title>
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body class="app-shell">
    @inertia
</body>
</html>
