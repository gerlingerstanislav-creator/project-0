<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <a href="{{ url('/tool-1') }}" class="sidebar__link {{ request()->is('tool-1') ? 'is-active' : '' }}"><span>1</span> Инструмент 1</a>
            <a href="{{ url('/tool-2') }}" class="sidebar__link {{ request()->is('tool-2') ? 'is-active' : '' }}"><span>2</span> Инструмент 2</a>
            <a href="{{ url('/tool-3') }}" class="sidebar__link {{ request()->is('tool-3') ? 'is-active' : '' }}"><span>3</span> Инструмент 3</a>
        </nav>
    </aside>
    <main class="content">{{ $slot }}</main>
    <div class="sidebar-backdrop" aria-hidden="true"></div>
    <script>
        const toggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');
        const closeMenu = () => { sidebar.classList.remove('is-open'); toggle.setAttribute('aria-expanded', 'false'); };
        toggle.addEventListener('click', () => { const open = sidebar.classList.toggle('is-open'); toggle.setAttribute('aria-expanded', String(open)); });
        backdrop.addEventListener('click', closeMenu);
        document.querySelectorAll('.sidebar__link').forEach(link => link.addEventListener('click', closeMenu));
    </script>
</body>
</html>
