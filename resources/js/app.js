import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const bootLegacyPageScripts = () => {
    const toggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const backdrop = document.querySelector('.sidebar-backdrop');

    if (toggle && sidebar && backdrop) {
        const setMenuState = (open) => {
            sidebar.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', String(open));

            const label = toggle.querySelector('.sr-only');
            if (label) {
                label.textContent = open ? 'Закрыть меню' : 'Открыть меню';
            }
        };

        toggle.addEventListener('click', () => {
            setMenuState(!sidebar.classList.contains('is-open'));
        });

        backdrop.addEventListener('click', () => setMenuState(false));

        document.querySelectorAll('.sidebar__link').forEach((link) => {
            link.addEventListener('click', () => setMenuState(false));
        });
    }

    if (document.querySelector('[data-beer-game-page]')) {
        import('./beer-game.js');
    }

    if (document.querySelector('[data-weather-app]')) {
        import('./ski-resort.js');
    }
};

if (document.getElementById('app')) {
    createInertiaApp({
        resolve: (name) => resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob('./pages/**/*.vue'),
        ),
        setup({ el, App, props, plugin }) {
            createApp({
                render: () => h(App, props),
            })
                .use(plugin)
                .mount(el);
        },
    });
} else {
    bootLegacyPageScripts();
}
