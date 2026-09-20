const toggle = document.querySelector('.menu-toggle');
const sidebar = document.querySelector('.sidebar');
const backdrop = document.querySelector('.sidebar-backdrop');

if (toggle && sidebar && backdrop) {
    const setMenuState = (open) => {
        sidebar.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.querySelector('.sr-only').textContent = open ? 'Закрыть меню' : 'Открыть меню';
    };

    toggle.addEventListener('click', () => {
        setMenuState(!sidebar.classList.contains('is-open'));
    });

    backdrop.addEventListener('click', () => setMenuState(false));

    document.querySelectorAll('.sidebar__link').forEach((link) => {
        link.addEventListener('click', () => setMenuState(false));
    });
}

if (document.querySelector('[data-startup-ideas-page]')) {
    import('./startup-ideas.js');
}

if (document.querySelector('[data-beer-game-page]')) {
    import('./beer-game.js');
}

if (document.querySelector('[data-weather-app]')) {
    import('./ski-resort.js');
}
