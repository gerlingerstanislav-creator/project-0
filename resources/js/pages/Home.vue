<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user ?? null);

const sections = [
    { href: '/tool-1', number: '01', title: 'Идеи стартапов', description: 'Каталог идей с оценкой, описанием и возможностью редактирования для разрешённых ролей.' },
    { href: '/tool-2', number: '02', title: 'Степан, выпей', description: 'Интерактивная мини-игра с бутылкой, стаканом и анимированным наливанием.' },
    { href: '/manager-cheat-sheets', number: '03', title: 'Менеджерские шпаргалки', description: 'Практические материалы и подсказки, собранные в удобные раскрывающиеся карточки.' },
    { href: '/ski-resort', number: '04', title: 'Горнолыжные курорты', description: 'Погода, прогнозы и веб-камеры популярных российских горнолыжных курортов.' },
    { href: '/news', number: '05', title: 'Новости', description: 'Персональная лента новостей с категориями, значимостью, релевантностью и пользовательской обратной связью.' },
    { href: '/tests', number: '06', title: 'Тесты', description: 'Инструменты для проверки PWA и push-уведомлений приложения.' },
    { href: '/design-system', number: '07', title: 'Дизайн-система', description: 'Каталог компонентов и визуальных правил интерфейса проекта.', roles: ['admin', 'moderator'] },
    { href: '/event-manager-training', number: '08', title: 'Обучение event-менеджера', description: 'Практическая программа от брифа и концепции до самостоятельного проведения мероприятий разной сложности.' },
];
</script>

<template>
    <Head title="Главная" />

    <AppLayout>
        <main class="home-page">
            <section class="home-hero" aria-labelledby="home-title">
                <div class="home-hero__glow home-hero__glow--one"></div>
                <div class="home-hero__glow home-hero__glow--two"></div>
                <div class="home-hero__content">
                    <p class="home-eyebrow">PROJECT-0 · WORKSPACE</p>
                    <h1 id="home-title">Все инструменты<br><span>в одном месте</span></h1>
                    <p class="home-lead">Набор рабочих инструментов, экспериментов и сервисов проекта. Выберите нужный раздел и продолжайте работу.</p>
                    <Link v-if="!user" href="/login" class="home-login ds-button">Войти в проект <span>→</span></Link>
                    <p v-else class="home-status">Вы авторизованы · все доступные вам разделы ниже</p>
                </div>
                <div class="home-hero__mark" aria-hidden="true">P0</div>
            </section>

            <section class="home-sections" aria-labelledby="sections-title">
                <div class="home-section-heading"><div><p class="home-eyebrow">NAVIGATION</p><h2 id="sections-title">Разделы проекта</h2></div><span>{{ sections.length }} разделов</span></div>
                <div class="section-grid">
                    <Link v-for="section in sections" :key="section.href" v-show="!section.roles || section.roles.includes(page.props.auth?.user?.role)" :href="section.href" class="section-card">
                        <span class="section-card__number">{{ section.number }}</span><div class="section-card__body"><h3>{{ section.title }}</h3><p>{{ section.description }}</p></div><span class="section-card__arrow" aria-hidden="true">↗</span>
                    </Link>
                </div>
            </section>
        </main>
    </AppLayout>
</template>

<style scoped>
.home-page{min-height:100%;padding:24px 24px 48px;max-width:1440px;margin:0 auto}.home-hero{position:relative;min-height:390px;display:flex;align-items:center;overflow:hidden;padding:64px clamp(28px,6vw,86px);border:1px solid var(--ds-border,#e8e2ee);border-radius:32px;background:linear-gradient(135deg,#20142f 0%,#38204e 48%,#6b3c7f 100%);box-shadow:0 28px 80px #39204b24;isolation:isolate}.home-hero__content{position:relative;z-index:2;max-width:760px}.home-eyebrow{margin:0 0 18px;font-size:12px;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:#d7bce7}.home-hero h1{margin:0;color:#fff;font-size:clamp(46px,7vw,88px);line-height:.94;letter-spacing:-.06em}.home-hero h1 span{color:#e7bdf2}.home-lead{max-width:650px;margin:24px 0 30px;color:#eadff0;font-size:18px;line-height:1.6}.home-login{display:inline-flex;align-items:center;gap:14px;text-decoration:none}.home-login span{font-size:20px}.home-status{margin:0;color:#d9c9e0;font-size:14px}.home-hero__mark{position:absolute;right:6%;bottom:-.12em;color:#ffffff0c;font-size:clamp(180px,28vw,390px);font-weight:900;line-height:.8;letter-spacing:-.12em;z-index:1}.home-hero__glow{position:absolute;border-radius:50%;filter:blur(8px);z-index:0}.home-hero__glow--one{width:360px;height:360px;right:12%;top:-180px;background:#e4a8ff38}.home-hero__glow--two{width:430px;height:430px;right:-130px;bottom:-280px;background:#6fb9ff2e}.home-sections{padding:54px 4px 0}.home-section-heading{display:flex;justify-content:space-between;align-items:end;gap:20px;margin-bottom:22px}.home-section-heading h2{margin:0;color:#281d31;font-size:clamp(30px,4vw,46px);letter-spacing:-.045em}.home-section-heading>span{padding-bottom:7px;color:#817486;font-size:13px}.section-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.section-card{position:relative;display:flex;gap:22px;align-items:flex-start;min-height:160px;padding:26px 28px;border:1px solid #e7e0eb;border-radius:22px;background:#fff;color:inherit;text-decoration:none;box-shadow:0 8px 30px #4d36500a;transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease}.section-card:hover{transform:translateY(-3px);border-color:#cdb4d8;box-shadow:0 18px 42px #4d365018}.section-card__number{font-size:12px;font-weight:800;letter-spacing:.12em;color:#a17eaf}.section-card__body{padding-right:26px}.section-card h3{margin:0 0 9px;color:#2c2034;font-size:20px;letter-spacing:-.02em}.section-card p{margin:0;color:#756b79;font-size:14px;line-height:1.55}.section-card__arrow{position:absolute;right:24px;top:22px;color:#a17eaf;font-size:20px;transition:transform .2s ease}.section-card:hover .section-card__arrow{transform:translate(3px,-3px)}@media(max-width:760px){.home-page{padding:12px 12px 32px}.home-hero{min-height:420px;padding:42px 26px;border-radius:24px}.home-hero h1{font-size:clamp(43px,13vw,68px)}.home-lead{font-size:16px}.home-sections{padding-top:38px}.section-grid{grid-template-columns:1fr}.section-card{min-height:140px;padding:22px}.home-section-heading{align-items:start;flex-direction:column;gap:6px}}@media(prefers-reduced-motion:reduce){.section-card,.section-card__arrow{transition:none}}
</style>
