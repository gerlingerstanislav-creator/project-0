<script setup>
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

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
        <header class="taxi-header">
            <a href="#top" class="brand" aria-label="Путь без преград — наверх">
                <span class="brand__symbol" aria-hidden="true">✳</span>
                <span>ПУТЬ <small>БЕЗ ПРЕГРАД</small></span>
            </a>
            <div class="taxi-header__right">
                <span class="taxi-header__city">Ульяновск и область</span>
                <span class="taxi-header__hours"><i></i> Работаем 24/7</span>
                <button type="button" class="text-link" @click="scrollToRequest">Заказать поездку <span aria-hidden="true">↗</span></button>
            </div>
        </header>

        <main id="top">
            <section class="hero">
                <div class="hero__copy">
                    <p class="eyebrow"><span class="eyebrow__line"></span> СПЕЦИАЛИЗИРОВАННЫЕ ПЕРЕВОЗКИ · 24/7</p>
                    <h1>Дорога должна <em>быть доступна</em> каждому.</h1>
                    <p class="hero__intro">Комфортные поездки для маломобильных пассажиров по Ульяновску и Ульяновской области — на оборудованном автомобиле, с сопровождением или без.</p>
                    <div class="hero__actions">
                        <button type="button" class="button button--primary" @click="scrollToRequest">Заказать поездку <span aria-hidden="true">↗</span></button>
                        <a href="#how-it-works" class="button button--outline">Как это работает <span aria-hidden="true">↓</span></a>
                    </div>
                    <div class="hero__facts">
                        <div><strong>24/7</strong><span>Принимаем обращения</span></div>
                        <div><strong>от 1 000 ₽</strong><span>Ориентир по стоимости</span></div>
                        <div><strong>01 / 02</strong><span>Поездки по городу и области</span></div>
                    </div>
                </div>
                <div class="hero__visual">
                    <div class="hero__visual-top"><span>ВАША ПОЕЗДКА — НАША ЗАБОТА</span><span>УЛЬЯНОВСК · 73</span></div>
                    <svg viewBox="0 0 690 460" role="img" aria-label="Иллюстрация специального автомобиля с подъемником для инвалидной коляски" class="hero__illustration">
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
                    </svg>
                    <div class="hero__visual-bottom"><span>Специальный транспорт</span><span class="visual-arrow" aria-hidden="true">↗</span></div>
                    <div class="floating-note"><span class="floating-note__icon">✓</span><span>Для важных поездок<br><strong>без лишних сложностей</strong></span></div>
                </div>
            </section>

            <section id="benefits" class="benefits section-wrap">
                <div class="section-heading"><div><p class="section-kicker">01 — НАШ ПОДХОД</p><h2>Заботимся не только<br>о маршруте.</h2></div><p>Поездка должна быть спокойной и понятной — для самого пассажира и его близких.</p></div>
                <div class="benefit-grid">
                    <article class="benefit-card"><div class="benefit-card__icon">↗</div><span>01</span><h3>Оперативно</h3><p>Не нужно планировать поездку за месяц. Свяжитесь с нами, чтобы обсудить ближайшее доступное время.</p></article>
                    <article class="benefit-card"><div class="benefit-card__icon">◇</div><span>02</span><h3>Надёжно</h3><p>Перевозка на специализированном транспорте с учётом потребностей пассажиров на колясках.</p></article>
                    <article class="benefit-card"><div class="benefit-card__icon">✦</div><span>03</span><h3>Комфортно</h3><p>Поможем организовать поездку на приём, обследование, встречу или по личным делам.</p></article>
                    <article class="benefit-card"><div class="benefit-card__icon">✳</div><span>04</span><h3>С сопровождением</h3><p>По запросу обсудим помощь сопровождающего. Возможна перевозка и без сопровождения.</p></article>
                </div>
            </section>

            <section id="how-it-works" class="process section-wrap">
                <div class="process__intro"><p class="section-kicker">02 — ПРОСТОЙ ПРОЦЕСС</p><h2>От заявки<br>до пункта назначения.</h2><p>Расскажите, куда нужно добраться и какая помощь потребуется. Мы уточним условия поездки и её стоимость.</p><button type="button" class="button button--light" @click="scrollToRequest">Обсудить маршрут <span aria-hidden="true">↗</span></button></div>
                <ol class="process__steps">
                    <li><b>01</b><div><h3>Оставляете запрос</h3><p>Указываете маршрут и контактный номер.</p></div></li>
                    <li><b>02</b><div><h3>Уточняем детали</h3><p>Обсуждаем время, необходимость сопровождения и цену.</p></div></li>
                    <li><b>03</b><div><h3>Отправляемся в путь</h3><p>Подбираем вариант поездки под запрос пассажира.</p></div></li>
                </ol>
            </section>

            <section id="pricing" class="price section-wrap">
                <div><p class="section-kicker">03 — СТОИМОСТЬ</p><h2>Понятная стоимость.<br>Без неожиданностей.</h2><p class="price__description">Окончательная цена зависит от расстояния, времени и необходимых дополнительных услуг. Обсудим все детали до поездки.</p></div>
                <div class="price__card"><span>СТОИМОСТЬ ПОЕЗДКИ</span><p>от <strong>1 000</strong> ₽</p><small>Предварительный ориентир. Точную стоимость назовём после уточнения маршрута.</small><button type="button" class="button button--primary" @click="scrollToRequest">Уточнить стоимость <span aria-hidden="true">↗</span></button></div>
            </section>

            <section id="request" class="request section-wrap">
                <div class="request__intro"><p class="section-kicker">04 — СВЯЗАТЬСЯ С НАМИ</p><h2>Расскажите,<br><em>куда нужно ехать.</em></h2><p>Заполните маршрут — так оператору будет проще сориентировать вас по условиям поездки.</p><div class="request__callout">Демонстрационная версия сайта: номера телефонов и отправка заявок будут подключены после согласования с заказчиком.</div></div>
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

        <footer class="taxi-footer"><div class="footer-brand">✳ <strong>ПУТЬ БЕЗ ПРЕГРАД</strong></div><p>Перевозка маломобильных пассажиров<br>Ульяновск и Ульяновская область</p><div><span>ГОРОДСКОЙ · 8 (8422) XXX-XX-XX</span><span>МОБИЛЬНЫЙ · 8 (9XX) XXX-XX-XX</span><small>Номера телефонов будут уточнены</small></div><a href="#top">Наверх ↑</a></footer>
    </div>
</template>

<style scoped>
.accessible-taxi{--ink:#172a3e;--muted:#657184;--accent:#e9b638;--wine:#782e47;--cream:#f6f4ef;min-height:100vh;background:var(--cream);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,sans-serif;overflow:hidden;scroll-behavior:smooth}.accessible-taxi *{box-sizing:border-box}.taxi-header{display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1480px;margin:auto;padding:24px clamp(24px,5vw,76px)}.brand{display:flex;align-items:center;gap:12px;color:var(--ink);font-weight:900;letter-spacing:.07em;text-decoration:none;font-size:16px;line-height:1.1}.brand small{display:block;font-size:11px;letter-spacing:.16em}.brand__symbol{display:grid;place-items:center;width:45px;height:45px;background:var(--accent);border-radius:12px;font-size:32px}.taxi-header__right{display:flex;align-items:center;gap:34px;font-size:12px;font-weight:700}.taxi-header__city{color:var(--muted)}.taxi-header__hours{white-space:nowrap}.taxi-header__hours i{display:inline-block;width:7px;height:7px;border-radius:50%;background:#429f65;margin-right:6px}.text-link{border:0;background:none;color:var(--ink);border-bottom:1px solid currentColor;padding:6px 0;cursor:pointer;font-size:13px;font-weight:800}.hero{max-width:1480px;margin:auto;padding:36px clamp(24px,5vw,76px) 90px;display:grid;grid-template-columns:1fr 1.04fr;gap:36px;align-items:center;min-height:690px}.hero__copy{padding:20px 0}.eyebrow,.section-kicker{font-size:11px;font-weight:900;letter-spacing:.2em}.eyebrow{display:flex;align-items:center;gap:12px;color:var(--wine);margin:0 0 34px}.eyebrow__line{width:28px;height:2px;background:var(--wine)}.hero h1{font-size:clamp(48px,5.7vw,88px);font-weight:850;letter-spacing:-.065em;line-height:1.03;margin:0;max-width:730px}.hero h1 em,.request h2 em{font-style:normal;color:var(--wine)}.hero__intro{max-width:520px;font-size:17px;line-height:1.75;color:#59667a;margin:30px 0}.hero__actions{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:54px}.button{display:inline-flex;align-items:center;justify-content:space-between;gap:30px;min-height:53px;border-radius:7px;border:1px solid transparent;padding:13px 22px;font:inherit;font-size:13px;font-weight:800;cursor:pointer;text-decoration:none;transition:transform .2s,background .2s}.button:hover:not(:disabled){transform:translateY(-2px)}.button--primary{background:var(--accent);color:#172a3e}.button--primary:hover:not(:disabled){background:#f3c753}.button--outline{background:transparent;border-color:#cfd3d4;color:var(--ink)}.button--light{background:#f6f4ef;color:var(--ink);margin-top:20px}.hero__facts{display:flex;gap:30px;flex-wrap:wrap}.hero__facts div{display:flex;flex-direction:column;gap:4px;padding-right:22px;border-right:1px solid #d4d2cc}.hero__facts div:last-child{border-right:0}.hero__facts strong{font-size:19px;letter-spacing:-.03em}.hero__facts span{font-size:11px;color:var(--muted)}.hero__visual{position:relative;min-height:490px;background:#243950;border-radius:18px;display:flex;flex-direction:column;justify-content:space-between;padding:25px;color:#fff;box-shadow:20px 20px 0 #e8e5dc}.hero__visual-top,.hero__visual-bottom{display:flex;justify-content:space-between;gap:10px;font-size:10px;font-weight:800;letter-spacing:.15em}.hero__visual-top{color:#bdc5cd}.hero__visual-bottom{align-items:center;font-size:12px;letter-spacing:normal}.hero__illustration{display:block;width:100%;height:auto;max-height:395px}.visual-arrow{font-size:29px}.floating-note{position:absolute;right:-25px;bottom:70px;display:flex;align-items:center;gap:10px;background:#fff;color:var(--ink);padding:14px 20px;box-shadow:0 10px 38px #0002;border-radius:9px;font-size:11px;line-height:1.6}.floating-note__icon{display:grid;place-items:center;background:#e8f0e8;color:#257a50;border-radius:50%;width:30px;height:30px;font-size:17px}.section-wrap{max-width:1480px;margin:auto;padding:100px clamp(24px,5vw,76px)}.section-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:40px;margin-bottom:40px}.section-kicker{color:var(--wine);margin:0 0 20px}.section-heading h2,.process h2,.price h2,.request h2{font-size:clamp(38px,4vw,64px);line-height:1.06;letter-spacing:-.055em;margin:0}.section-heading>p{max-width:340px;color:var(--muted);font-size:15px;line-height:1.7}.benefits{background:#f6f4ef}.benefit-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px}.benefit-card{background:#fff;border:1px solid #ece9e1;border-radius:12px;min-height:296px;padding:26px;display:flex;flex-direction:column;align-items:flex-start}.benefit-card__icon{display:grid;place-items:center;background:#f7efda;color:var(--wine);border-radius:10px;font-size:28px;width:54px;height:54px;margin-bottom:auto}.benefit-card>span{font-size:11px;color:#a7a9a9;margin:20px 0 5px}.benefit-card h3{margin:0 0 10px;font-size:22px;letter-spacing:-.035em}.benefit-card p{margin:0;color:var(--muted);line-height:1.6;font-size:13px}.process{display:grid;grid-template-columns:1fr 1fr;gap:80px;background:#243950;color:#fff;max-width:none;padding-left:max(24px,calc((100vw - 1328px)/2));padding-right:max(24px,calc((100vw - 1328px)/2))}.process .section-kicker{color:#f6c450}.process__intro>p:not(.section-kicker){color:#c1cbd6;line-height:1.8;max-width:460px}.process__steps{margin:0;padding:0;list-style:none}.process__steps li{display:flex;gap:28px;padding:26px 0;border-bottom:1px solid #526173}.process__steps li:first-child{border-top:1px solid #526173}.process__steps b{font-size:12px;color:#f0bc42}.process__steps h3{margin:0 0 8px;font-size:20px}.process__steps p{margin:0;color:#c1cbd6;font-size:14px;line-height:1.6}.price{display:grid;grid-template-columns:1fr 1fr;gap:75px;align-items:center}.price__description{max-width:430px;line-height:1.8;color:var(--muted);font-size:16px}.price__card{background:#fff;border:1px solid #e9e3d9;border-radius:17px;padding:40px}.price__card>span{font-size:11px;font-weight:800;letter-spacing:.15em;color:var(--wine)}.price__card p{font-size:37px;margin:24px 0 12px;white-space:nowrap;letter-spacing:-.05em}.price__card strong{font-size:clamp(62px,6vw,96px);letter-spacing:-.07em}.price__card small{display:block;max-width:420px;font-size:13px;line-height:1.6;color:var(--muted);margin-bottom:30px}.request{display:grid;grid-template-columns:.9fr 1.1fr;gap:80px;background:#efece6;max-width:none;padding-left:max(24px,calc((100vw - 1328px)/2));padding-right:max(24px,calc((100vw - 1328px)/2))}.request__intro>p:not(.section-kicker){color:var(--muted);line-height:1.8;max-width:410px}.request__callout{max-width:390px;margin-top:35px;padding:16px;border-left:3px solid var(--wine);background:#e4ddd6;font-size:12px;line-height:1.7;color:#5c5560}.request__form{background:#fff;padding:35px;border-radius:15px;display:flex;flex-direction:column;gap:8px;box-shadow:0 12px 60px #172a3e0b}.request__form h3{margin:0 0 20px;font-size:25px;letter-spacing:-.04em}.request__form label{font-size:12px;font-weight:800;margin-top:10px}.request__form input{background:#faf9f7;border:1px solid #dddcd9;padding:15px 14px;border-radius:6px;width:100%;min-width:0;font:inherit;font-size:14px;color:var(--ink)}.request__form input:focus{outline:2px solid var(--accent);outline-offset:1px}.form-pair{display:grid;grid-template-columns:1fr 1fr;gap:12px}.form-pair>div{display:flex;flex-direction:column;gap:8px}.button--form{width:100%;margin-top:18px}.button--form:disabled{cursor:not-allowed;opacity:.58}.form-note{margin:8px 0 0;color:var(--muted);font-size:11px;line-height:1.6}.taxi-footer{max-width:1480px;margin:auto;display:flex;justify-content:space-between;gap:24px;padding:45px clamp(24px,5vw,76px);align-items:flex-start;font-size:12px;color:var(--muted)}.footer-brand{color:var(--ink);font-size:14px}.footer-brand strong{margin-left:6px}.taxi-footer p{margin:0;line-height:1.7}.taxi-footer>div:nth-last-of-type(1){display:flex;flex-direction:column;gap:7px}.taxi-footer small{color:#a7a19c}.taxi-footer>a{color:var(--ink);font-weight:800;text-decoration:none}@media(max-width:1100px){.hero{gap:30px}.hero__visual{min-height:400px}.benefit-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.process,.request{gap:36px}.hero__facts{gap:15px}.hero__facts div{padding-right:12px}.hero__facts strong{font-size:17px}}@media(max-width:760px){.taxi-header{padding:18px 20px}.taxi-header__city,.taxi-header__hours{display:none}.hero{display:flex;flex-direction:column;align-items:stretch;gap:32px;padding:30px 20px 70px;min-height:auto}.hero__copy{padding:0}.hero h1{font-size:clamp(44px,11vw,68px)}.hero__intro{font-size:15px}.hero__actions{margin-bottom:35px}.hero__facts{gap:20px}.hero__visual{min-height:320px;padding:16px;box-shadow:8px 8px 0 #e8e5dc}.floating-note{right:0;bottom:50px;padding:10px}.section-wrap{padding:65px 20px}.section-heading{display:block}.section-heading>p{max-width:none}.benefit-grid{grid-template-columns:1fr 1fr}.benefit-card{min-height:270px;padding:20px}.process,.price,.request{display:flex;flex-direction:column;gap:35px}.taxi-footer{padding:35px 20px;display:grid;grid-template-columns:1fr 1fr}.form-pair{grid-template-columns:1fr}.request__form{padding:22px}}@media(max-width:480px){.brand{font-size:13px}.brand__symbol{width:37px;height:37px;font-size:25px}.text-link{font-size:11px}.hero__facts div{border:0}.hero__visual{min-height:260px}.hero__visual-top{font-size:8px}.floating-note{display:none}.benefit-grid{grid-template-columns:1fr}.benefit-card{min-height:210px}.benefit-card__icon{margin-bottom:14px}.benefit-card>span{margin:0 0 5px}.taxi-footer{grid-template-columns:1fr}.price__card{padding:25px}.price__card strong{font-size:65px}.hero__actions .button{width:100%}}@media(prefers-reduced-motion:reduce){.button{transition:none}}
</style>
