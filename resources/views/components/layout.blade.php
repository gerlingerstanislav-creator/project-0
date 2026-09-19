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
    <title>{{ $title ?? 'Инструменты' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    <button class="menu-toggle" type="button" aria-controls="sidebar" aria-expanded="false">
        <span></span><span></span><span></span>
        <span class="sr-only">Открыть меню</span>
    </button>

    <aside id="sidebar" class="sidebar">
        <div class="sidebar__brand">Tools</div>

        <nav class="sidebar__nav" aria-label="Основная навигация">
            <a href="{{ url('/tool-1') }}" class="sidebar__link {{ request()->is('tool-1') ? 'is-active' : '' }}"><span>1</span> Идеи стартапов</a>
            <a href="{{ url('/tool-2') }}" class="sidebar__link {{ request()->is('tool-2') ? 'is-active' : '' }}"><span>2</span> Инструмент 2</a>
            <a href="{{ url('/tool-3') }}" class="sidebar__link {{ request()->is('tool-3') ? 'is-active' : '' }}"><span>3</span> Инструмент 3</a>
        </nav>

        <div class="sidebar__account">
            @auth
                <div class="sidebar__account-label">Аккаунт</div>
                <div class="sidebar__account-name">{{ auth()->user()->username }}</div>
                <div class="sidebar__account-role">{{ auth()->user()->roleLabel() }}</div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="sidebar__logout" type="submit">Выйти</button>
                </form>
            @endauth
        </div>
    </aside>

    <main class="content">{{ $slot }}</main>
    <div class="sidebar-backdrop" aria-hidden="true"></div>
</body>
</html>
