<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const menuOpen = ref(false);

const user = computed(() => page.props.auth?.user ?? null);
const currentPath = computed(() => page.url.split('?')[0]);

const links = [
    { href: '/tool-1', label: 'Идеи стартапов', number: '1' },
    { href: '/tool-2', label: 'Инструмент 2', number: '2' },
    { href: '/tool-3', label: 'Инструмент 3', number: '3' },
    { href: '/manager-cheat-sheets', label: 'Менеджерские шпаргалки', number: '4' },
    { href: '/ski-resort', label: 'Горнолыжные курорты', number: '5' },
];

const isActive = (href) => currentPath.value === href;
const closeMenu = () => { menuOpen.value = false; };
</script>

<template>
    <button
        class="menu-toggle"
        type="button"
        aria-controls="sidebar"
        :aria-expanded="menuOpen"
        @click="menuOpen = !menuOpen"
    >
        <span></span>
        <span></span>
        <span></span>
        <span class="sr-only">{{ menuOpen ? 'Закрыть меню' : 'Открыть меню' }}</span>
    </button>

    <aside id="sidebar" class="sidebar" :class="{ 'is-open': menuOpen }">
        <div class="sidebar__brand">STools</div>

        <nav class="sidebar__nav" aria-label="Основная навигация">
            <template v-for="link in links" :key="link.href">
                <Link
                    v-if="link.href === '/tool-1'"
                    :href="link.href"
                    class="sidebar__link"
                    :class="{ 'is-active': isActive(link.href) }"
                    @click="closeMenu"
                >
                    <span>{{ link.number }}</span>
                    {{ link.label }}
                </Link>
                <a
                    v-else
                    :href="link.href"
                    class="sidebar__link"
                    :class="{ 'is-active': isActive(link.href) }"
                    @click="closeMenu"
                >
                    <span>{{ link.number }}</span>
                    {{ link.label }}
                </a>
            </template>
        </nav>

        <div class="sidebar__account">
            <template v-if="user">
                <div class="sidebar__account-label">Аккаунт</div>
                <div class="sidebar__account-name">{{ user.username }}</div>
                <div class="sidebar__account-role">
                    {{ user.role === 'admin' ? 'Администратор' : user.role === 'editor' ? 'Редактор' : 'Наблюдатель' }}
                </div>
                <form method="POST" action="/logout">
                    <input type="hidden" name="_token" :value="page.props.csrfToken">
                    <button type="submit" class="sidebar__logout" @click="closeMenu">Выйти</button>
                </form>
            </template>

            <a v-else href="/login" class="sidebar__login" @click="closeMenu">Войти</a>
        </div>
    </aside>

    <main class="content">
        <slot />
    </main>

    <button
        v-if="menuOpen"
        class="sidebar-backdrop"
        type="button"
        aria-label="Закрыть меню"
        @click="closeMenu"
    ></button>
</template>
