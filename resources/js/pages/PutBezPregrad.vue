<script setup>
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const primaryPhone = '8 (8422) 71-73-03';
const primaryPhoneHref = 'tel:+78422717303';
const secondaryPhone = '8 (967) 771-73-03';
const secondaryPhoneHref = 'tel:+79677717303';
const email = 'bezpregrad73@yandex.ru';
const maxUrl = 'https://max.ru/u/f9LHodD0cOIMqlrwFHrhALk5VeAh-knTiBJCLnhZSFM3iMksBuOEXJ6JMec';
const departure = ref('');
const destination = ref('');
const passenger = ref('');
const contact = ref('');
const requestReady = computed(() => departure.value.trim() && destination.value.trim() && contact.value.trim());
const scrollToRequest = () => document.getElementById('request')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
</script>

<template>
    <Head title="Путь без преград — перевозка маломобильных пассажиров в Ульяновске">
        <meta name="description" content="Перевозка людей на инвалидных колясках по Ульяновску и Ульяновской области. Специализированный транспорт, сопровождение, поездки 24/7." />
    </Head>

    <div class="accessible-taxi">
        <header class="taxi-header"><a href="#top" class="brand" aria-label="Путь без преград — наверх"><span class="brand__symbol" aria-hidden="true">♿</span><span>ПУТЬ <small>БЕЗ ПРЕГРАД</small></span></a>
<div class="taxi-header__right"><div class="header-phones"><a :href="primaryPhoneHref">{{ primaryPhone }}</a><a :href="secondaryPhoneHref">{{ secondaryPhone }}</a></div><a class="header-email" :href="`mailto:${email}`">{{ email }}</a><a :href="maxUrl" target="_blank" rel="noopener noreferrer" aria-label="Написать в MAX" class="max-link"><span class="max-icon">M</span> MAX</a></div></header>

        <main id="top">
            <section class="hero"><div class="hero__copy"><p class="eyebrow">СПЕЦТРАНСПОРТ · УЛЬЯНОВСК И ОБЛАСТЬ · 24/7</p><h1>Перевозка инвалидов-колясочников <em>в спецавтомобиле</em> по городу и области</h1>
<div class="hero__contact"><div class="hero__phone"><span class="hero__phone-label">ЗВОНИТЕ КРУГЛОСУТОЧНО</span><a :href="primaryPhoneHref" class="hero__phone-number" aria-label="Позвонить по номеру 8 8422 71 73 03"><span class="hero__phone-prefix">8 (8422)</span><strong>71-73-03</strong></a><a :href="secondaryPhoneHref" class="hero__phone-secondary">{{ secondaryPhone }}</a></div><a :href="primaryPhoneHref" class="button button--primary hero__request-button">☎ Позвонить</a></div>
<p class="hero__subactions"><a href="#request">Оставить заявку</a> · <a :href="maxUrl" target="_blank" rel="noopener noreferrer">Написать в MAX</a></p></div>
<div class="hero__visual"><div class="hero__visual-top"><span>ДОСТУПНЫЕ ПОЕЗДКИ</span><span>24/7</span></div><svg viewBox="0 0 690 460" role="img" aria-label="Иллюстрация специального автомобиля с подъемником для инвалидной коляски" class="hero__illustration">
                        <defs>
                            <linearGradient id="vanBody" x1="0" x2="1" y1="0" y2="1"><stop stop-color="#f8f6ef"/><stop offset="1" stop-color="#dedfd9"/></linearGradient>
                            <linearGradient id="vanGlass" x1="0" x2="1"><stop stop-color="#273a57"/><stop offset="1" stop-color="#56748b"/></linearGradient>
                        </defs>
                        <circle cx="395" cy="206" r="184" fill="#e9b93e" opacity=".17"/>
                        <circle cx="390" cy="210" r="139" fill="none" stroke="#e9b93e" stroke-width="1.5" stroke-dasharray="5 9" opacity=".7"/>
                        <path d="M65 343H648" stroke="#314457" stroke-width="3" stroke-linecap="round" opacity=".45"/>
                        <path d="M104 301V198Q104 175 127 171L237 154H480Q506 154 517 175L569 245H599Q620 245 620 268V316H100Z" fill="url(#vanBody)" stroke="#263548" stroke-width="6" stroke-linejoin="round"/>
                        <path d="M253 167H472Q495 167 503 186L533 233H251Z" fill="url(#vanGlass)" stroke="#263548" stroke-width="5" stroke-linejoin="round"/>
                        <path d="M257 167V237" stroke="#e9e9e0" stroke-width="7"/>
                        <path d="M374 167V237" stroke="#e9e9e0" stroke-width="7"/>
                        <path d="M105 246H619" stroke="#263548" stroke-width="3" opacity=".22"/>
                        <path d="M128 265H217" stroke="#ddb039" stroke-width="12" stroke-linecap="round"/>
                        <path d="M441 265H530" stroke="#ddb039" stroke-width="12" stroke-linecap="round"/>
                        <path d="M554 265H590" stroke="#263548" stroke-width="8" stroke-linecap="round"/>
                        <circle cx="209" cy="318" r="45" fill="#263548"/><circle cx="209" cy="318" r="23" fill="#f2eddf"/><circle cx="209" cy="318" r="9" fill="#b7b9b5"/>
                        <circle cx="514" cy="318" r="45" fill="#263548"/><circle cx="514" cy="318" r="23" fill="#f2eddf"/><circle cx="514" cy="318" r="9" fill="#b7b9b5"/>
                        <rect x="292" y="253" width="64" height="40" rx="7" fill="#f1c247"/>
                        <circle cx="325" cy="265" r="7" fill="#263548"/>
                        <path d="M325 275L311 287M325 275L338 285M325 275L325 283" stroke="#263548" stroke-width="4" stroke-linecap="round"/>
                        <path d="M117 204H205L223 184" stroke="#fff" stroke-width="7" stroke-linecap="round" opacity=".55"/>
                        <path d="M587 305H621" stroke="#e8bc48" stroke-width="12" stroke-linecap="round"/>
                        <path d="M62 357H643" stroke="#e8bc48" stroke-width="4" stroke-linecap="round" stroke-dasharray="20 15"/>
                    </svg><div class="hero__visual-bottom"><span>Специальный транспорт</span><span class="visual-arrow" aria-hidden="true">↗</span></div></div>
<div class="hero__facts"><div><strong>24/7</strong><span>На связи ежедневно</span></div><div><strong>от 1 500 ₽</strong><span>Стоимость поездки</span></div><div><strong>С сопровождением</strong><span>Или без сопровождения</span></div></div></section>
<section id="benefits" class="benefits section-wrap">
                <div class="section-heading"><div><p class="section-kicker">01 — НАШ ПОДХОД</p><h2>Заботимся не только<br>о маршруте.</h2></div><p>Поездка должна быть спокойной и понятной — для самого пассажира и его близких.</p></div>
                <div class="benefit-grid">
                    <article class="benefit-card"><div class="benefit-card__icon">↗</div><span>01</span><h3>Оперативно</h3><p>Не нужно планировать поездку за месяц. Свяжитесь с нами, чтобы обсудить ближайшее доступное время.</p></article>
                    <article class="benefit-card"><div class="benefit-card__icon">◇</div><span>02</span><h3>Надёжно</h3><p>Перевозка на специализированном транспорте с учётом потребностей пассажиров на колясках.</p></article>
                    <article class="benefit-card"><div class="benefit-card__icon">✦</div><span>03</span><h3>Комфортно</h3><p>Поможем организовать поездку на приём, обследование, встречу или по личным делам.</p></article>
                    <article class="benefit-card"><div class="benefit-card__icon">✳</div><span>04</span><h3>С сопровождением</h3><p>По запросу обсудим помощь сопровождающего. Возможна перевозка и без сопровождения.</p></article>
                </div>
            </section>

            <section id="destinations" class="destinations section-wrap"><div class="section-heading"><div><p class="section-kicker">02 — КУДА ПЕРЕВОЗИМ</p><h2>Поможем добраться<br>куда необходимо.</h2></div><p>Поездки по Ульяновску и области. Маршрут согласовываем заранее.</p></div><div class="destination-grid"><article><span aria-hidden="true">✚</span><h3>Из больницы домой</h3><p>После лечения</p></article><article><span aria-hidden="true">✚</span><h3>Из дома в поликлинику</h3><p>К врачу</p></article><article><span aria-hidden="true">▣</span><h3>Из дома в МФЦ</h3><p>Для оформления документов</p></article><article><span aria-hidden="true">✦</span><h3>На обследование</h3><p>Диагностика и процедуры</p></article><article><span aria-hidden="true">⌂</span><h3>В социальные учреждения</h3><p>По важным вопросам</p></article><article><span aria-hidden="true">↗</span><h3>По личным делам</h3><p>Поездки и встречи</p></article></div></section>
<section id="fleet" class="fleet section-wrap"><div class="section-heading"><div><p class="section-kicker">03 — НАШ АВТОПАРК</p><h2>Специальный транспорт.</h2></div><p>Автомобиль ожидается. Реальные фото добавим после его получения.</p></div><div class="fleet-grid"><article class="fleet-card"><div class="fleet-art fleet-art--0" role="img" aria-label="Временная концептуальная иллюстрация: Специальный автомобиль"><span>🚐</span></div><div class="fleet-card__body"><h3>Специальный автомобиль</h3><p>Транспорт для людей на инвалидных колясках</p></div></article><article class="fleet-card"><div class="fleet-art fleet-art--1" role="img" aria-label="Временная концептуальная иллюстрация: Пассажир на коляске"><span>♿</span></div><div class="fleet-card__body"><h3>Пассажир на коляске</h3><p>Поездка с учётом потребностей человека</p></div></article><article class="fleet-card"><div class="fleet-art fleet-art--2" role="img" aria-label="Временная концептуальная иллюстрация: Посадка в автомобиль"><span>♿ ↗ 🚐</span></div><div class="fleet-card__body"><h3>Посадка в автомобиль</h3><p>Необходимую помощь обсуждаем заранее</p></div></article></div><p class="fleet-disclaimer">Пока здесь концептуальные иллюстрации вместо фотографий реального автопарка.</p></section>
<section id="how-it-works" class="process section-wrap">
                <div class="process__intro"><p class="section-kicker">04 — ПРОСТОЙ ПРОЦЕСС</p><h2>От заявки<br>до пункта назначения.</h2><p>Расскажите, куда нужно добраться и какая помощь потребуется. Мы уточним условия поездки и её стоимость.</p><button type="button" class="button button--light" @click="scrollToRequest">Обсудить маршрут <span aria-hidden="true">↗</span></button></div>
                <ol class="process__steps">
                    <li><b>01</b><div><h3>Оставляете запрос</h3><p>Указываете маршрут и контактный номер.</p></div></li>
                    <li><b>02</b><div><h3>Уточняем детали</h3><p>Обсуждаем время, необходимость сопровождения и цену.</p></div></li>
                    <li><b>03</b><div><h3>Отправляемся в путь</h3><p>Подбираем вариант поездки под запрос пассажира.</p></div></li>
                </ol>
            </section>

            <section id="pricing" class="price section-wrap">
                <div><p class="section-kicker">05 — СТОИМОСТЬ</p><h2>Понятная стоимость.<br>Без неожиданностей.</h2><p class="price__description">Окончательная цена зависит от расстояния, времени и необходимых дополнительных услуг. Обсудим все детали до поездки.</p></div>
                <div class="price__card"><span>СТОИМОСТЬ ПОЕЗДКИ</span><p>от <strong>1 500</strong> ₽</p><small>Предварительный ориентир. Точную стоимость назовём после уточнения маршрута.</small><button type="button" class="button button--primary" @click="scrollToRequest">Уточнить стоимость <span aria-hidden="true">↗</span></button></div>
            </section>

            <section id="request" class="request section-wrap">
                <div class="request__intro"><p class="section-kicker">06 — СВЯЗАТЬСЯ С НАМИ</p><h2>Расскажите,<br><em>куда нужно ехать.</em></h2><p>Заполните маршрут — так оператору будет проще сориентировать вас по условиям поездки.</p><div class="request__callout">Телефоны и MAX доступны для связи. Отправка заявок через форму пока не подключена.</div></div>
                <form class="request__form" @submit.prevent>
                    <h3>Предварительный запрос</h3>
                    <label for="taxi-from">Откуда забрать пассажира</label><input id="taxi-from" v-model="departure" type="text" autocomplete="street-address" placeholder="Адрес отправления" />
                    <label for="taxi-to">Куда доставить</label><input id="taxi-to" v-model="destination" type="text" placeholder="Адрес назначения" />
                    <div class="form-pair"><div><label for="taxi-person">Имя (необязательно)</label><input id="taxi-person" v-model="passenger" type="text" autocomplete="name" placeholder="Как к вам обращаться" /></div><div><label for="taxi-phone">Номер телефона</label><input id="taxi-phone" v-model="contact" type="tel" autocomplete="tel" placeholder="+7 (___) ___-__-__" /></div></div>
                    <button class="button button--primary button--form" type="button" disabled>Отправка скоро появится <span aria-hidden="true">→</span></button>
                    <p class="form-note">{{ requestReady ? 'Маршрут заполнен. На демонстрационной странице данные не отправляются.' : 'Это предварительный расчёт: точная стоимость уточняется по телефону. Сейчас форма не отправляет данные.' }}</p>
                </form>
            </section>
        </main>

        <footer class="taxi-footer"><div class="footer-brand">♿ <strong>ПУТЬ БЕЗ ПРЕГРАД</strong><p>Ульяновск и область · 24/7</p></div><div class="footer-contacts"><a :href="primaryPhoneHref">{{ primaryPhone }}</a><a :href="secondaryPhoneHref">{{ secondaryPhone }}</a><a :href="`mailto:${email}`">{{ email }}</a></div><a class="max-link" :href="maxUrl" target="_blank" rel="noopener noreferrer" aria-label="Написать в MAX"><span class="max-icon">M</span> MAX</a><a href="#top">Наверх ↑</a></footer>
    </div>
</template>

<style scoped>
.accessible-taxi{--ink:#172a3e;--muted:#657184;--accent:#e9b638;--wine:#782e47;--cream:#f6f4ef;min-height:100vh;background:var(--cream);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,sans-serif;overflow:hidden;scroll-behavior:smooth}.accessible-taxi *{box-sizing:border-box}.taxi-header{display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1480px;margin:auto;padding:24px clamp(24px,5vw,76px)}.brand{display:flex;align-items:center;gap:12px;color:var(--ink);font-weight:900;letter-spacing:.07em;text-decoration:none;font-size:16px;line-height:1.1}.brand small{display:block;font-size:11px;letter-spacing:.16em}.brand__symbol{display:grid;place-items:center;width:45px;height:45px;background:var(--accent);border-radius:12px;font-size:32px}.taxi-header__right{display:flex;align-items:center;gap:34px;font-size:12px;font-weight:700}.taxi-header__city{color:var(--muted)}.taxi-header__hours{white-space:nowrap}.taxi-header__hours i{display:inline-block;width:7px;height:7px;border-radius:50%;background:#429f65;margin-right:6px}.text-link{border:0;background:none;color:var(--ink);border-bottom:1px solid currentColor;padding:6px 0;cursor:pointer;font-size:13px;font-weight:800}.hero{max-width:1480px;margin:auto;padding:36px clamp(24px,5vw,76px) 90px;display:grid;grid-template-columns:1fr 1.04fr;gap:36px;align-items:center;min-height:690px}.hero__copy{padding:20px 0}.eyebrow,.section-kicker{font-size:11px;font-weight:900;letter-spacing:.2em}.eyebrow{display:flex;align-items:center;gap:12px;color:var(--wine);margin:0 0 34px}.eyebrow__line{width:28px;height:2px;background:var(--wine)}.hero h1{font-size:clamp(48px,5.7vw,88px);font-weight:850;letter-spacing:-.065em;line-height:1.03;margin:0;max-width:730px}.hero h1 em,.request h2 em{font-style:normal;color:var(--wine)}.hero__intro{max-width:520px;font-size:17px;line-height:1.75;color:#59667a;margin:30px 0}.hero__actions{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:54px}.button{display:inline-flex;align-items:center;justify-content:space-between;gap:30px;min-height:53px;border-radius:7px;border:1px solid transparent;padding:13px 22px;font:inherit;font-size:13px;font-weight:800;cursor:pointer;text-decoration:none;transition:transform .2s,background .2s}.button:hover:not(:disabled){transform:translateY(-2px)}.button--primary{background:var(--accent);color:#172a3e}.button--primary:hover:not(:disabled){background:#f3c753}.button--outline{background:transparent;border-color:#cfd3d4;color:var(--ink)}.button--light{background:#f6f4ef;color:var(--ink);margin-top:20px}.hero__facts{display:flex;gap:30px;flex-wrap:wrap}.hero__facts div{display:flex;flex-direction:column;gap:4px;padding-right:22px;border-right:1px solid #d4d2cc}.hero__facts div:last-child{border-right:0}.hero__facts strong{font-size:19px;letter-spacing:-.03em}.hero__facts span{font-size:11px;color:var(--muted)}.hero__visual{position:relative;min-height:490px;background:#243950;border-radius:18px;display:flex;flex-direction:column;justify-content:space-between;padding:25px;color:#fff;box-shadow:20px 20px 0 #e8e5dc}.hero__visual-top,.hero__visual-bottom{display:flex;justify-content:space-between;gap:10px;font-size:10px;font-weight:800;letter-spacing:.15em}.hero__visual-top{color:#bdc5cd}.hero__visual-bottom{align-items:center;font-size:12px;letter-spacing:normal}.hero__illustration{display:block;width:100%;height:auto;max-height:395px}.visual-arrow{font-size:29px}.floating-note{position:absolute;right:-25px;bottom:70px;display:flex;align-items:center;gap:10px;background:#fff;color:var(--ink);padding:14px 20px;box-shadow:0 10px 38px #0002;border-radius:9px;font-size:11px;line-height:1.6}.floating-note__icon{display:grid;place-items:center;background:#e8f0e8;color:#257a50;border-radius:50%;width:30px;height:30px;font-size:17px}.section-wrap{max-width:1480px;margin:auto;padding:100px clamp(24px,5vw,76px)}.section-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:40px;margin-bottom:40px}.section-kicker{color:var(--wine);margin:0 0 20px}.section-heading h2,.process h2,.price h2,.request h2{font-size:clamp(38px,4vw,64px);line-height:1.06;letter-spacing:-.055em;margin:0}.section-heading>p{max-width:340px;color:var(--muted);font-size:15px;line-height:1.7}.benefits{background:#f6f4ef}.benefit-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px}.benefit-card{background:#fff;border:1px solid #ece9e1;border-radius:12px;min-height:296px;padding:26px;display:flex;flex-direction:column;align-items:flex-start}.benefit-card__icon{display:grid;place-items:center;background:#f7efda;color:var(--wine);border-radius:10px;font-size:28px;width:54px;height:54px;margin-bottom:auto}.benefit-card>span{font-size:11px;color:#a7a9a9;margin:20px 0 5px}.benefit-card h3{margin:0 0 10px;font-size:22px;letter-spacing:-.035em}.benefit-card p{margin:0;color:var(--muted);line-height:1.6;font-size:13px}.process{display:grid;grid-template-columns:1fr 1fr;gap:80px;background:#243950;color:#fff;max-width:none;padding-left:max(24px,calc((100vw - 1328px)/2));padding-right:max(24px,calc((100vw - 1328px)/2))}.process .section-kicker{color:#f6c450}.process__intro>p:not(.section-kicker){color:#c1cbd6;line-height:1.8;max-width:460px}.process__steps{margin:0;padding:0;list-style:none}.process__steps li{display:flex;gap:28px;padding:26px 0;border-bottom:1px solid #526173}.process__steps li:first-child{border-top:1px solid #526173}.process__steps b{font-size:12px;color:#f0bc42}.process__steps h3{margin:0 0 8px;font-size:20px}.process__steps p{margin:0;color:#c1cbd6;font-size:14px;line-height:1.6}.price{display:grid;grid-template-columns:1fr 1fr;gap:75px;align-items:center}.price__description{max-width:430px;line-height:1.8;color:var(--muted);font-size:16px}.price__card{background:#fff;border:1px solid #e9e3d9;border-radius:17px;padding:40px}.price__card>span{font-size:11px;font-weight:800;letter-spacing:.15em;color:var(--wine)}.price__card p{font-size:37px;margin:24px 0 12px;white-space:nowrap;letter-spacing:-.05em}.price__card strong{font-size:clamp(62px,6vw,96px);letter-spacing:-.07em}.price__card small{display:block;max-width:420px;font-size:13px;line-height:1.6;color:var(--muted);margin-bottom:30px}.request{display:grid;grid-template-columns:.9fr 1.1fr;gap:80px;background:#efece6;max-width:none;padding-left:max(24px,calc((100vw - 1328px)/2));padding-right:max(24px,calc((100vw - 1328px)/2))}.request__intro>p:not(.section-kicker){color:var(--muted);line-height:1.8;max-width:410px}.request__callout{max-width:390px;margin-top:35px;padding:16px;border-left:3px solid var(--wine);background:#e4ddd6;font-size:12px;line-height:1.7;color:#5c5560}.request__form{background:#fff;padding:35px;border-radius:15px;display:flex;flex-direction:column;gap:8px;box-shadow:0 12px 60px #172a3e0b}.request__form h3{margin:0 0 20px;font-size:25px;letter-spacing:-.04em}.request__form label{font-size:12px;font-weight:800;margin-top:10px}.request__form input{background:#faf9f7;border:1px solid #dddcd9;padding:15px 14px;border-radius:6px;width:100%;min-width:0;font:inherit;font-size:14px;color:var(--ink)}.request__form input:focus{outline:2px solid var(--accent);outline-offset:1px}.form-pair{display:grid;grid-template-columns:1fr 1fr;gap:12px}.form-pair>div{display:flex;flex-direction:column;gap:8px}.button--form{width:100%;margin-top:18px}.button--form:disabled{cursor:not-allowed;opacity:.58}.form-note{margin:8px 0 0;color:var(--muted);font-size:11px;line-height:1.6}.taxi-footer{max-width:1480px;margin:auto;display:flex;justify-content:space-between;gap:24px;padding:45px clamp(24px,5vw,76px);align-items:flex-start;font-size:12px;color:var(--muted)}.footer-brand{color:var(--ink);font-size:14px}.footer-brand strong{margin-left:6px}.taxi-footer p{margin:0;line-height:1.7}.taxi-footer>div:nth-last-of-type(1){display:flex;flex-direction:column;gap:7px}.taxi-footer small{color:#a7a19c}.taxi-footer>a{color:var(--ink);font-weight:800;text-decoration:none}@media(max-width:1100px){.hero{gap:30px}.hero__visual{min-height:400px}.benefit-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.process,.request{gap:36px}.hero__facts{gap:15px}.hero__facts div{padding-right:12px}.hero__facts strong{font-size:17px}}@media(max-width:760px){.taxi-header{padding:18px 20px}.taxi-header__city,.taxi-header__hours{display:none}.hero{display:flex;flex-direction:column;align-items:stretch;gap:32px;padding:30px 20px 70px;min-height:auto}.hero__copy{padding:0}.hero h1{font-size:clamp(44px,11vw,68px)}.hero__intro{font-size:15px}.hero__actions{margin-bottom:35px}.hero__facts{gap:20px}.hero__visual{min-height:320px;padding:16px;box-shadow:8px 8px 0 #e8e5dc}.floating-note{right:0;bottom:50px;padding:10px}.section-wrap{padding:65px 20px}.section-heading{display:block}.section-heading>p{max-width:none}.benefit-grid{grid-template-columns:1fr 1fr}.benefit-card{min-height:270px;padding:20px}.process,.price,.request{display:flex;flex-direction:column;gap:35px}.taxi-footer{padding:35px 20px;display:grid;grid-template-columns:1fr 1fr}.form-pair{grid-template-columns:1fr}.request__form{padding:22px}}@media(max-width:480px){.brand{font-size:13px}.brand__symbol{width:37px;height:37px;font-size:25px}.text-link{font-size:11px}.hero__facts div{border:0}.hero__visual{min-height:260px}.hero__visual-top{font-size:8px}.floating-note{display:none}.benefit-grid{grid-template-columns:1fr}.benefit-card{min-height:210px}.benefit-card__icon{margin-bottom:14px}.benefit-card>span{margin:0 0 5px}.taxi-footer{grid-template-columns:1fr}.price__card{padding:25px}.price__card strong{font-size:65px}.hero__actions .button{width:100%}}@media(prefers-reduced-motion:reduce){.button{transition:none}}

/* Enhanced readability for visitors with low vision. Overrides the decorative small type. */
.accessible-taxi{--muted:#36485a;font-size:18px;line-height:1.6}
.accessible-taxi p,.accessible-taxi li{overflow-wrap:break-word}
.accessible-taxi :is(a,button,input):focus-visible{outline:3px solid #8a304d;outline-offset:4px}
.accessible-taxi :is(a,button){touch-action:manipulation}
.accessible-taxi :is(.section-kicker,.eyebrow,.taxi-header__right,.text-link,.hero__facts span,.benefit-card>span,.hero__visual-top,.hero__visual-bottom,.price__card>span,.request__form label,.form-note,.taxi-footer,.request__callout,.floating-note,.hero__phone-label){font-size:16px;letter-spacing:.035em}
.accessible-taxi :is(.hero__intro,.section-heading>p,.benefit-card p,.process__intro>p:not(.section-kicker),.process__steps p,.price__description,.request__intro>p:not(.section-kicker),.price__card small,.request__form input){font-size:18px;line-height:1.65;color:var(--ink)}
.accessible-taxi .process :is(.process__intro>p:not(.section-kicker),.process__steps p){color:#fff}
.accessible-taxi .hero__facts strong{font-size:24px}
.accessible-taxi .benefit-card h3,.accessible-taxi .process__steps h3{font-size:26px}
.accessible-taxi .benefit-card>span{color:#455369}
.accessible-taxi .hero__visual-top{color:#fff}
.accessible-taxi .hero__facts span{color:#36485a}
.accessible-taxi .button{font-size:18px;min-height:56px}
.accessible-taxi .request__form label{font-size:17px}
.accessible-taxi .form-note{color:#36485a}
.accessible-taxi .taxi-footer{font-size:16px}
.accessible-taxi .taxi-footer small{color:#36485a;font-size:15px}
.accessible-taxi .taxi-footer a{color:#172a3e;text-decoration:underline;text-underline-offset:4px}
.accessible-taxi .request__callout{font-size:16px;color:#392f37}
.accessible-taxi .request__form input::placeholder{color:#5a6676;opacity:1}
.hero__phone{display:flex;flex-direction:column;align-items:flex-start;gap:9px;margin:0 0 25px;padding:20px 23px;border:2px solid #172a3e;border-radius:14px;background:#fff;box-shadow:0 6px 0 #e9b638}
.hero__phone-label{font-weight:900;color:#782e47}
.hero__phone-number{display:flex;align-items:center;gap:12px;max-width:100%;color:#172a3e;font-size:clamp(27px,2.5vw,40px);font-weight:900;letter-spacing:-.035em;text-decoration:underline;text-decoration-thickness:2px;text-underline-offset:6px;line-height:1.25}
.hero__phone-number:not(.hero__phone-number--placeholder):hover{color:#782e47}
.hero__phone-number--placeholder{text-decoration:none;overflow-wrap:anywhere}
.hero__phone-description{font-size:16px;color:#36485a;font-weight:600;line-height:1.5}
.accessible-taxi .hero__actions{margin-bottom:36px}
@media(max-width:760px){
  .accessible-taxi .hero__intro{font-size:18px}
  .accessible-taxi .benefit-card{min-height:auto}
  .accessible-taxi .taxi-header__right .text-link{font-size:16px}
  .hero__phone{padding:18px}
  .hero__phone-number{font-size:clamp(25px,7vw,38px)}
  .hero__phone-label{font-size:15px}
  .accessible-taxi .button{width:100%;justify-content:center;gap:16px}
  .accessible-taxi .hero__facts strong{font-size:22px}
}
@media(forced-colors:active){.hero__phone{border:2px solid CanvasText}.accessible-taxi :is(a,button,input):focus-visible{outline:3px solid Highlight}}

/* The introductory screen is one two-column composition with a shared info row.
   Contact details live in the copy flow, not in a competing floating card. */
.hero{
  grid-template-columns:minmax(0,1.04fr) minmax(0,.96fr);
  grid-template-rows:auto auto;
  column-gap:clamp(30px,4vw,64px);
  row-gap:36px;
  align-items:center;
  min-height:0;
  padding-top:30px;
  padding-bottom:60px;
}
.hero__copy{min-width:0;padding:0}
.hero .eyebrow{margin-bottom:20px}
.hero h1{font-size:clamp(44px,4.65vw,72px);line-height:1.08;letter-spacing:-.052em}
.accessible-taxi .hero__intro{margin:20px 0 26px;line-height:1.55;max-width:610px}
.hero__contact{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:18px 0;border-top:2px solid #d4d3cd;border-bottom:2px solid #d4d3cd}
.hero__phone{display:flex;flex-direction:column;align-items:flex-start;gap:5px;min-width:0;flex:1 1 auto;margin:0;padding:0;border:0;border-radius:0;box-shadow:none;background:transparent}
.hero__phone-number{font-size:clamp(26px,2.55vw,38px);gap:9px;min-width:0;white-space:normal}
.hero__phone-label{font-size:15px}
.hero__phone-description{font-size:14px;line-height:1.4}
.hero__request-button{flex:0 0 auto;min-height:60px;gap:15px}
.hero__visual{min-height:360px;box-shadow:none}
.hero__illustration{max-height:335px}
.hero__facts{grid-column:1/-1;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:0;padding:20px 0 0;border-top:1px solid #d4d3cd}
.hero__facts div{display:flex;flex-direction:column;gap:2px;padding:0 24px;min-width:0;border-right:1px solid #d4d3cd}
.hero__facts div:first-child{padding-left:0}
.hero__facts div:last-child{border-right:0}
.accessible-taxi .hero__facts strong{font-size:clamp(19px,2vw,26px)}
.accessible-taxi .hero__facts span{font-size:16px}
@media(max-width:1190px){
  .hero{grid-template-columns:minmax(0,1fr) minmax(0,.86fr);gap:28px}
  .hero__contact{flex-wrap:wrap}
  .hero__request-button{width:100%;justify-content:center}
  .hero h1{font-size:clamp(43px,4.6vw,62px)}
}
@media(max-width:900px){
  .hero{display:grid;grid-template-columns:minmax(0,1fr);gap:26px;padding-top:25px}
  .hero__copy,.hero__visual,.hero__facts{grid-column:1}
  .hero__copy{max-width:760px}
  .hero__visual{min-height:300px}
  .hero__contact{flex-wrap:nowrap}
  .hero__request-button{width:auto}
}
@media(max-width:600px){
  .hero{padding:20px 20px 48px;gap:24px}
  .hero h1{font-size:clamp(39px,10vw,56px)}
  .hero .eyebrow{margin-bottom:18px}
  .hero__contact{flex-direction:column;align-items:stretch;gap:16px}
  .hero__phone{width:100%}
  .hero__phone-number{font-size:clamp(26px,7.2vw,38px)}
  .hero__request-button{width:100%}
  .hero__facts{grid-template-columns:1fr;gap:14px;padding-top:17px}
  .hero__facts div,.hero__facts div:first-child{padding:0 0 14px;border-right:0;border-bottom:1px solid #d4d3cd}
  .hero__facts div:last-child{border-bottom:0;padding-bottom:0}
  .hero__visual{min-height:250px}
  .hero__phone-description{font-size:14px}
}

.accessible-taxi{--ink:#101e30;--muted:#314457;--accent:#db1034;--wine:#be052a;--cream:#f6fafc;background:#f6fafc}
.taxi-header{max-width:1560px;background:white}.brand__symbol{background:#df1034;color:white}
.header-phones{display:grid;gap:3px}.header-phones a,.header-email{color:#101e30;font-size:16px;font-weight:800;text-decoration:none;white-space:nowrap}
.header-phones a:hover,.header-email:hover{text-decoration:underline}
.max-link{display:inline-flex;align-items:center;gap:8px;color:#111f31;text-decoration:none;font-weight:900;font-size:17px;white-space:nowrap}
.max-icon{width:36px;height:36px;border-radius:10px;display:grid;place-items:center;background:linear-gradient(135deg,#6454ef,#00a5ed);color:white;font-size:24px}
.hero h1{font-size:clamp(40px,4.4vw,68px);line-height:1.12}.hero h1 em{color:#c8002c}
.hero__visual{background:linear-gradient(135deg,#20334b,#0c7884)}.hero__phone-number{text-decoration:none;display:flex;align-items:baseline;gap:10px;flex-wrap:wrap}.hero__phone-prefix{font-size:clamp(19px,1.8vw,27px);font-weight:800}.hero__phone-number strong{font-size:clamp(40px,4vw,62px);letter-spacing:-.05em;line-height:1.03}.hero__phone-secondary{font-size:21px;font-weight:800;color:#314457;text-decoration:none}.hero__phone-number:hover,.hero__phone-secondary:hover{text-decoration:underline;color:#b8002b}
.hero__contact{gap:16px}.hero__request-button,.button--primary{background:#dc1036;color:white}.hero__request-button:hover,.button--primary:hover:not(:disabled){background:#aa092a;color:white}.hero__subactions{display:flex;gap:14px;font-size:18px;font-weight:800}.hero__subactions a{color:#af062e}.hero__facts{border-top:3px solid #e00b32}
.destination-grid,.fleet-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.destinations{background:#eaf5f8}
.destination-grid article{border:1px solid #d4e5ea;background:white;border-radius:14px;padding:24px;min-height:175px}
.destination-grid article>span{display:grid;place-items:center;width:52px;height:52px;background:#ffe8ed;color:#c0002e;font-size:28px;font-weight:900;border-radius:10px;margin-bottom:15px}
.destination-grid h3,.fleet-card h3{font-size:23px;line-height:1.25;margin:0 0 9px}.destination-grid p,.fleet-card p{font-size:18px;line-height:1.5;color:#314457;margin:0}
.fleet{background:white}.fleet-card{background:#f7fbfd;border:1px solid #d5e3e9;border-radius:14px;overflow:hidden}.fleet-card__body{padding:24px}.fleet-art{height:260px;display:grid;place-items:center;background:linear-gradient(145deg,#d7edf3,#91bfce)}.fleet-art>span{font-size:120px;filter:drop-shadow(3px 12px 4px #304c5d35)}.fleet-art--1{background:linear-gradient(145deg,#e0eef2,#b5d5df)}.fleet-art--2{background:linear-gradient(145deg,#deeff0,#a5d4da)}.fleet-art--2>span{font-size:62px}.fleet-disclaimer{font-size:16px;color:#314457}
.price__card{border:2px solid #db1034}.price__card strong{color:#c5002b}.request{background:#e8f5f8}
.taxi-footer{max-width:none;background:#142c3b;color:white;flex-wrap:wrap;align-items:center}.taxi-footer .footer-brand,.taxi-footer .footer-brand strong,.taxi-footer>a,.footer-contacts a{color:white!important}.footer-contacts{display:grid;gap:7px}.footer-contacts a{font-size:17px;font-weight:800;text-decoration:none}.footer-brand p{font-size:15px;color:#e1eef2}.taxi-footer .max-link{color:white}
.accessible-taxi :is(a,button,input):focus-visible{outline:4px solid #00a5b5;outline-offset:4px}
@media(max-width:1180px){.header-email{display:none}.hero__contact{flex-wrap:wrap}}
@media(max-width:900px){.taxi-header{flex-wrap:wrap}.taxi-header__right{margin-left:auto}.destination-grid,.fleet-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:680px){.taxi-header__right{width:100%;justify-content:space-between;gap:8px}.header-phones a{font-size:15px}.hero__contact{flex-direction:column;align-items:stretch}.hero__request-button{width:100%}.hero__phone-number strong{font-size:clamp(40px,11.3vw,62px)}.hero__phone-secondary{font-size:19px}.destination-grid,.fleet-grid{grid-template-columns:1fr}.fleet-art{height:220px}.taxi-footer{display:grid;grid-template-columns:1fr}}
</style>
