<script setup>
import { Head } from '@inertiajs/vue3';
import TransportIcon from '../components/TransportIcon.vue';
import MaxIcon from '../components/MaxIcon.vue';
import { ref } from 'vue';

const primaryPhone = '8 (8422) 71-73-03';
const primaryPhoneHref = 'tel:+78422717303';
const secondaryPhone = '8 (967) 771-73-03';
const secondaryPhoneHref = 'tel:+79677717303';
const email = 'bezpregrad73@yandex.ru';
const maxUrl = 'https://max.ru/u/f9LHodD0cOIMqlrwFHrhALk5VeAh-knTiBJCLnhZSFM3iMksBuOEXJ6JMec';
const brandLogo = '/images/put-bez-pregrad/logo.svg';
const brandLogoLight = '/images/put-bez-pregrad/logo-light.svg';
const brandFavicon = '/images/put-bez-pregrad/favicon.svg';
const photoVan = '/images/accessible-van.avif';
const photoPassenger = '/images/accessible-passenger.avif';
const photoBoarding = '/images/accessible-boarding.avif';
const departure = ref('');
const destination = ref('');
const passenger = ref('');
const contact = ref('');
const mobileMenuOpen = ref(false);
const closeMenu = () => { mobileMenuOpen.value = false; };

// Until server-side request delivery is configured, provide a real email action
// rather than a form that silently discards the visitor's personal details.
const sendRequestEmail = () => {
  if (!departure.value.trim() || !destination.value.trim() || !contact.value.trim()) return;

  const subject = 'Заявка на перевозку — Путь без преград';
  const details = [
    'Здравствуйте! Прошу связаться со мной по поводу перевозки.',
    '',
    `Откуда: ${departure.value.trim()}`,
    `Куда: ${destination.value.trim()}`,
    `Имя: ${passenger.value.trim() || 'Не указано'}`,
    `Телефон: ${contact.value.trim()}`,
  ].join('\n');

  window.location.href = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(details)}`;
};
</script>


<template>
  <Head title="Путь без преград — перевозка людей на инвалидных колясках">
    <meta name="description" content="Перевозка людей на инвалидных колясках в спецавтомобиле по Ульяновску и области. С сопровождением или без. Звоните: 8 (8422) 71-73-03." />
    <link rel="icon" type="image/svg+xml" sizes="any" :href="brandFavicon" />
  </Head>
  <div class="accessible-taxi" id="top">
    <header class="site-header">
      <div class="site-header__inner">
        <a href="#top" class="logo" aria-label="Путь без преград — наверх">
          <img class="logo__image" :src="brandLogo" width="300" height="93" alt="Путь без преград — доступные перевозки" />
        </a>
        <button
          type="button"
          class="transport-menu-toggle"
          :aria-expanded="mobileMenuOpen"
          aria-controls="landing-navigation"
          @click="mobileMenuOpen = !mobileMenuOpen"
        >
          <svg viewBox="0 0 24 24" width="23" height="23" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path v-if="mobileMenuOpen" d="M5 5 19 19M19 5 5 19" />
            <path v-else d="M4 7h16M4 12h16M4 17h16" />
          </svg>
          <span>{{ mobileMenuOpen ? 'Закрыть' : 'Меню' }}</span>
        </button>
        <nav
          id="landing-navigation"
          class="header-nav"
          :class="{ 'header-nav--open': mobileMenuOpen }"
          aria-label="Разделы страницы"
          @keydown.esc="closeMenu"
        >
          <a href="#benefits" @click="closeMenu">Преимущества</a>
          <a href="#destinations" @click="closeMenu">Куда перевозим</a>
          <a href="#fleet" @click="closeMenu">Автопарк</a>
          <a href="#pricing" @click="closeMenu">Цены</a>
          <a href="#request" @click="closeMenu">Как заказать</a>
        </nav>
        <div class="header-contacts">
          <div class="header-phones">
            <a :href="primaryPhoneHref">{{ primaryPhone }}</a>
            <a :href="secondaryPhoneHref">{{ secondaryPhone }}</a>
          </div>
          <a class="header-email" :href="'mailto:' + email">{{ email }}</a>
          <a class="max-link" :href="maxUrl" target="_blank" rel="noopener noreferrer" aria-label="Написать в MAX"><span class="max-icon"><MaxIcon /></span></a>
        </div>
      </div>
    </header>

    <main>
      <section class="hero" aria-labelledby="hero-title">
        <div class="hero__image" aria-hidden="true">
          <img :src="photoVan" alt="" width="900" height="675" fetchpriority="high" decoding="async" />
        </div>
        <div class="hero__content container">
          <div class="hero__text">
            <p class="eyebrow">УЛЬЯНОВСК И УЛЬЯНОВСКАЯ ОБЛАСТЬ · 24/7</p>
            <h1 id="hero-title">Перевозка инвалидов-колясочников <em>в спецавтомобиле</em> по городу и области</h1>
            <div class="hero__phone-panel">
              <span class="hero__phone-label">Позвоните и закажите поездку</span>
              <a :href="primaryPhoneHref" class="hero__phone" aria-label="Позвонить на номер 8 8422 71 73 03">
                <span class="hero__phone-prefix">8 (8422)</span>
                <strong>71-73-03</strong>
              </a>
              <a :href="secondaryPhoneHref" class="hero__secondary">{{ secondaryPhone }}</a>
            </div>
            <div class="hero__actions">
              <a :href="primaryPhoneHref" class="cta cta--red"><span aria-hidden="true">☎</span> Позвонить сейчас</a>
              <a :href="maxUrl" target="_blank" rel="noopener noreferrer" class="cta cta--white" aria-label="Написать в MAX"><span class="max-icon"><MaxIcon /></span> Написать</a>
              <a href="#request" class="cta cta--outline">Оставить заявку</a>
            </div>
          </div>
          <div class="hero__stamp" aria-label="Круглосуточная связь"><strong>24/7</strong><span>На связи<br>каждый день</span></div>
        </div>
      </section>

      <section class="benefits container" id="benefits" aria-labelledby="benefits-title">
        <h2 id="benefits-title" class="visually-hidden">Почему выбирают нас</h2>
        <div class="benefits__grid">
          <article><span class="benefits__icon"><TransportIcon name="clock" /></span><div><h3>Быстро</h3><p>Обсудим ближайшее доступное время</p></div></article>
          <article><span class="benefits__icon"><TransportIcon name="shield" /></span><div><h3>Надёжно</h3><p>Специализированный транспорт</p></div></article>
          <article><span class="benefits__icon"><TransportIcon name="armchair" /></span><div><h3>Удобно</h3><p>Поездка с учётом потребностей пассажира</p></div></article>
          <article><span class="benefits__icon"><TransportIcon name="heart-hand" /></span><div><h3>С сопровождением</h3><p>Помощь при необходимости</p></div></article>
        </div>
      </section>

      <section class="destinations container" id="destinations" aria-labelledby="destinations-title">
        <div class="section-heading"><div><span class="eyebrow">НАПРАВЛЕНИЯ ПОЕЗДОК</span><h2 id="destinations-title">Куда перевозим</h2></div><p>От медицинских учреждений до повседневных дел. Обсудим маршрут и необходимые условия заранее.</p></div>
        <div class="destination-grid">
          <article><span class="destination-icon"><TransportIcon name="hospital" /></span><h3>Из больницы домой</h3><p>После лечения и выписки</p></article>
          <article><span class="destination-icon"><TransportIcon name="stethoscope" /></span><h3>Из дома в поликлинику</h3><p>На приём к врачу</p></article>
          <article><span class="destination-icon"><TransportIcon name="file-check" /></span><h3>Из дома в МФЦ</h3><p>Для оформления документов</p></article>
          <article><span class="destination-icon"><TransportIcon name="activity" /></span><h3>На обследование</h3><p>На диагностику и процедуры</p></article>
          <article><span class="destination-icon"><TransportIcon name="landmark" /></span><h3>В социальные учреждения</h3><p>По важным вопросам</p></article>
          <article><span class="destination-icon"><TransportIcon name="map-pin" /></span><h3>По личным делам</h3><p>На встречи и мероприятия</p></article>
        </div>
      </section>

      <section class="fleet" id="fleet" aria-labelledby="fleet-title">
        <div class="container">
          <div class="section-heading"><div><span class="eyebrow">ФОТОГАЛЕРЕЯ</span><h2 id="fleet-title">Наш автопарк</h2></div><p>Спецавтомобиль для перевозки людей на инвалидных колясках — с оборудованным местом для посадки.</p></div>
          <div class="fleet-grid">
            <article class="fleet-card">
              <img :src="photoVan" alt="Серый спецминивэн с открытой задней дверью и пандусом для инвалидной коляски" width="900" height="675" loading="lazy" decoding="async" />
              <div class="fleet-card__body"><h3>Специализированный автомобиль</h3><p>Транспорт с доступной посадкой</p></div>
            </article>
            <article class="fleet-card">
              <img :src="photoPassenger" alt="Женщина на инвалидной коляске рядом с серым спецминивэном и сопровождающим" width="900" height="675" loading="lazy" decoding="async" />
              <div class="fleet-card__body"><h3>Комфорт пассажира</h3><p>Забота о человеке в течение поездки</p></div>
            </article>
            <article class="fleet-card">
              <img :src="photoBoarding" alt="Сопровождающий помогает пассажиру на коляске подняться по пандусу в серый спецминивэн" width="900" height="675" loading="lazy" decoding="async" />
              <div class="fleet-card__body"><h3>Помощь при посадке</h3><p>Возможность сопровождения по запросу</p></div>
            </article>
          </div>
          <p class="fleet__note">Изображения сгенерированы для демонстрации услуги. Это не фотографии реального автомобиля компании.</p>
        </div>
      </section>

      <section class="order container" id="pricing" aria-labelledby="pricing-title">
        <div class="price-panel">
          <span class="eyebrow">СТОИМОСТЬ ПЕРЕВОЗКИ</span>
          <h2 id="pricing-title">Поездка <span>от 1 500 ₽</span></h2>
          <p>Стоимость зависит от маршрута и дополнительных услуг. Точную цену сообщим после уточнения деталей.</p>
          <a :href="primaryPhoneHref" class="cta cta--white">☎ Уточнить по телефону</a>
        </div>
        <div class="request-panel" id="request">
          <span class="eyebrow">ЗАЯВКА НА ПЕРЕВОЗКУ</span>
          <h2>Расскажите, куда нужно ехать</h2>
          <p>Заполните данные: мы подготовим письмо с маршрутом для отправки. Также можно позвонить или написать в MAX.</p>
          <form class="request-form" @submit.prevent="sendRequestEmail">
            <label for="taxi-from">Откуда забрать</label>
            <input id="taxi-from" v-model.trim="departure" type="text" autocomplete="street-address" placeholder="Адрес отправления" required maxlength="250" />
            <label for="taxi-to">Куда доставить</label>
            <input id="taxi-to" v-model.trim="destination" type="text" placeholder="Адрес назначения" required maxlength="250" />
            <div class="request-form__row">
              <div><label for="taxi-person">Ваше имя</label><input id="taxi-person" v-model.trim="passenger" type="text" autocomplete="name" placeholder="Имя" maxlength="120" /></div>
              <div><label for="taxi-phone">Телефон для связи</label><input id="taxi-phone" v-model.trim="contact" type="tel" autocomplete="tel" placeholder="+7 (___) ___-__-__" required minlength="6" maxlength="35" /></div>
            </div>
            <button type="submit" class="cta cta--red">Подготовить письмо с заявкой</button>
            <small id="request-note">Откроется ваша почтовая программа с заполненными данными. Проверьте письмо и нажмите «Отправить». Заявка не передаётся автоматически.</small>
            <a :href="primaryPhoneHref" class="cta cta--outline">Позвонить для заказа</a>
          </form>
        </div>
      </section>
    </main>
    <footer class="site-footer">
      <div class="container site-footer__inner">
        <div class="footer-brand"><a class="footer-brand__link" href="#top" aria-label="Путь без преград — наверх"><img :src="brandLogoLight" class="footer-brand__image" width="300" height="93" alt="Путь без преград — доступные перевозки" /></a><p>Перевозка людей на инвалидных колясках<br>Ульяновск и Ульяновская область</p></div>
        <nav aria-label="Навигация в подвале"><a href="#benefits">Преимущества</a><a href="#destinations">Куда перевозим</a><a href="#fleet">Автопарк</a><a href="#pricing">Стоимость</a><a href="#request">Контакты</a></nav>
        <div class="footer-contact"><a :href="primaryPhoneHref">{{ primaryPhone }}</a><a :href="secondaryPhoneHref">{{ secondaryPhone }}</a><a :href="'mailto:' + email">{{ email }}</a></div>
        <a class="max-link" :href="maxUrl" target="_blank" rel="noopener noreferrer" aria-label="Написать в MAX"><span class="max-icon"><MaxIcon /></span></a>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.accessible-taxi{--red:#df1036;--ink:#152135;--blue:#087e92;--muted:#3b4a5c;--pale:#f1f6f8;background:#fff;color:var(--ink);font:inherit;font-size:18px;line-height:1.5;overflow:clip}
.accessible-taxi *{box-sizing:border-box}
.accessible-taxi :is(a,button,input):focus-visible{outline:3px solid var(--blue);outline-offset:4px}
.accessible-taxi :is(a,button){touch-action:manipulation}
.container{width:min(100% - 48px,1350px);margin-inline:auto}
.visually-hidden{position:absolute!important;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
.site-header{background:#fff;border-bottom:1px solid #e2e8ee;position:sticky;top:0;z-index:100;box-shadow:0 5px 22px #122e4510}
.site-header__inner{max-width:1500px;padding:14px 26px;margin:auto;display:flex;align-items:center;gap:30px;justify-content:space-between}
.logo{display:flex;align-items:center;gap:12px;flex:0 0 auto;text-decoration:none;color:var(--ink);line-height:1.04;font-size:20px;font-weight:900}
.logo__image{display:block;width:260px;max-width:100%;height:auto}
.header-nav{display:flex;align-items:center;gap:22px;flex-wrap:wrap;justify-content:center}
.header-nav a,.site-footer nav a{font-size:14px;font-weight:800;text-decoration:none;color:var(--ink)}
.header-nav a:hover{text-decoration:underline;color:#bd0929}
.header-contacts{display:flex;align-items:center;gap:19px}
.header-phones{display:grid;gap:2px;white-space:nowrap}
.header-phones a,.header-email{font-size:15px;color:var(--ink);font-weight:800;text-decoration:none}
.header-phones a:hover,.header-email:hover{color:#b40028;text-decoration:underline}
.max-link{display:inline-flex;align-items:center;gap:8px;white-space:nowrap;font-weight:900;font-size:15px;text-decoration:none;color:inherit}
.max-icon{display:inline-grid;place-items:center;width:38px;height:38px;flex:0 0 auto;border-radius:11px;background:linear-gradient(135deg,#28bde7,#6256dc 72%,#8b39d9);color:#fff;box-shadow:0 5px 15px #2c70ba29}
.max-icon svg{display:block;width:26px;height:26px}
.max-link{min-width:44px;min-height:44px;justify-content:center}
.hero{position:relative;background:linear-gradient(95deg,#eff9fe 0%,#e6f0f3 50%,#cde0e7 100%);min-height:580px;display:flex;align-items:center;isolation:isolate;overflow:hidden}
.hero__image{position:absolute;inset:0 0 0 43%;z-index:-1;overflow:hidden}
.hero__image img{width:100%;height:100%;object-fit:cover;object-position:50% 50%;filter:saturate(1.15)}
.hero__image:before{content:'';position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,#ecf7fa 0%,#ecf7fae0 13%,#ecf7fa20 42%,#0000 75%)}
.hero__content{position:relative;display:flex;align-items:center;justify-content:space-between;padding-block:45px 55px;min-height:580px}
.hero__text{width:min(680px,65%);position:relative;z-index:1}
.eyebrow{display:block;color:#b90a30;font-size:13px;font-weight:900;letter-spacing:.08em;line-height:1.5;margin:0 0 14px}
.hero h1{font-size:clamp(36px,4vw,63px);line-height:1.1;font-weight:900;letter-spacing:-.045em;margin:0 0 22px}
.hero h1 em{font-style:normal;color:var(--red)}
.hero__phone-panel{padding:17px 20px;border-radius:15px;background:#fffffff0;box-shadow:0 8px 30px #1f344d19;width:fit-content;max-width:100%;margin-bottom:16px}
.hero__phone-label{display:block;font-size:16px;font-weight:800}
.hero__phone{display:flex;gap:12px;align-items:baseline;flex-wrap:wrap;color:var(--red);text-decoration:none;font-weight:900;line-height:1.05}
.hero__phone-prefix{font-size:clamp(17px,1.8vw,25px);color:var(--ink)}
.hero__phone strong{font-size:clamp(34px,4.2vw,65px);letter-spacing:-.045em}
.hero__phone:hover strong{text-decoration:underline}
.hero__secondary{display:block;margin-top:10px;color:var(--ink);font-size:20px;font-weight:800;text-decoration:none}
.hero__secondary:hover{text-decoration:underline}
.hero__actions{display:flex;gap:11px;flex-wrap:wrap}
.cta{min-height:56px;border-radius:12px;padding:14px 21px;display:inline-flex;align-items:center;justify-content:center;gap:11px;font:inherit;font-size:17px;font-weight:900;border:2px solid transparent;text-decoration:none;cursor:pointer}
.cta--red{background:var(--red);color:#fff}
.cta--red:hover:not(:disabled){background:#b8092c}
.cta--white{background:#fff;color:var(--ink);border-color:#d8e2ea}
.cta--white:hover{border-color:var(--blue)}
.cta--outline{background:transparent;color:var(--ink);border-color:#93a7b4}
.cta--outline:hover{background:#fff}
.cta:disabled{opacity:.55;cursor:not-allowed}
.hero__stamp{position:absolute;right:0;top:40px;display:grid;gap:1px;padding:13px 19px;border-radius:16px;background:var(--red);color:#fff;transform:rotate(5deg);box-shadow:0 12px 25px #82253e30}
.hero__stamp strong{font-size:32px;line-height:1.1}
.hero__stamp span{font-size:13px;font-weight:800}
.benefits{padding-block:28px 26px}
.benefits__grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px}
.benefits article{border-radius:18px;background:#f1f6fa;padding:22px;display:flex;gap:13px;align-items:flex-start}
.benefits__icon{display:grid;place-items:center;background:white;color:var(--red);border-radius:13px;min-width:52px;height:52px;font-size:29px;font-weight:900}
.benefits h3{margin:0 0 4px;font-size:21px;line-height:1.3}
.benefits p{margin:0;color:var(--muted);font-size:16px;line-height:1.5}
.section-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:30px;margin-bottom:24px}
.section-heading h2{font-size:clamp(31px,3vw,46px);line-height:1.12;margin:0;letter-spacing:-.04em}
.section-heading>p{font-size:17px;color:var(--muted);max-width:440px;margin:0;line-height:1.55}
.destinations{padding-block:45px 53px}
.destination-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
.destination-grid article{padding:22px;border:1px solid #e3eaf0;border-radius:17px;background:#f9fbfd;min-height:164px}
.destination-icon{display:grid;place-items:center;width:44px;height:44px;border-radius:11px;margin-bottom:11px;color:var(--red);background:#ffecf0;font-size:28px;font-weight:900}
.destination-grid h3{font-size:20px;line-height:1.25;margin:0 0 6px}
.destination-grid p{font-size:16px;color:var(--muted);margin:0}
.fleet{background:#eaf4f8;padding-block:48px 50px}
.fleet-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
.fleet-card{background:white;border-radius:17px;overflow:hidden;box-shadow:0 5px 18px #17324214}
.fleet-card img{width:100%;height:248px;object-fit:cover;display:block;background:#b9d0dd}
.fleet-card__body{padding:22px}
.fleet-card h3{margin:0 0 7px;font-size:21px;line-height:1.3}
.fleet-card p{margin:0;font-size:16px;color:var(--muted)}
.fleet__note{font-size:15px;color:var(--muted);line-height:1.5;margin:15px 0 0}
.order{display:grid;grid-template-columns:minmax(0,.84fr) minmax(0,1.16fr);gap:20px;padding-block:54px 66px;align-items:stretch}
.price-panel{background:linear-gradient(130deg,#e11137,#b6082b);color:white;border-radius:20px;padding:clamp(26px,4vw,46px);display:flex;flex-direction:column;align-items:start}
.price-panel .eyebrow{color:white}
.price-panel h2{font-size:clamp(34px,4vw,55px);line-height:1.1;margin:14px 0}
.price-panel h2 span{display:block;font-size:clamp(41px,5vw,69px);white-space:nowrap}
.price-panel p{font-size:18px;max-width:440px;margin:0 0 24px}
.price-panel .cta{margin-top:auto}
.request-panel{background:#eff8fb;border-radius:20px;padding:clamp(26px,4vw,46px)}
.request-panel h2{font-size:clamp(29px,3vw,39px);line-height:1.14;margin:0 0 13px}
.request-panel>p{margin:0 0 20px;font-size:17px;color:var(--muted)}
.request-form{display:grid;gap:9px}
.request-form label{font-weight:800;font-size:16px;margin-top:5px}
.request-form input{display:block;width:100%;min-width:0;min-height:50px;padding:12px;border:1px solid #9fb0c0;border-radius:9px;font:inherit;font-size:17px;background:white;color:var(--ink)}
.request-form__row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.request-form__row>div{min-width:0}
.request-form__row label{display:block}
.request-form small{font-size:14px;color:var(--muted)}
.request-form .cta{width:100%;text-align:center}
.site-footer{background:#152531;color:#f7fbfe;padding-block:38px}
.site-footer__inner{display:flex;gap:28px;justify-content:space-between;align-items:flex-start}
.footer-brand__link{display:inline-block;text-decoration:none}
.footer-brand__image{display:block;width:276px;max-width:100%;height:auto}
.footer-brand p{font-size:15px;color:#d1dce5;line-height:1.6;margin:8px 0 0}
.site-footer nav,.footer-contact{display:flex;flex-direction:column;gap:9px}
.site-footer nav a,.footer-contact a{font-size:16px;color:#fff;text-decoration:none;font-weight:700}
.site-footer a:hover{text-decoration:underline}
@media(max-width:1250px){.header-nav{display:none}.site-header__inner{flex-wrap:wrap}.header-email{display:none}.hero__image{left:42%}}
@media(max-width:900px){.hero__content{min-height:550px}.hero__text{width:min(650px,75%)}.hero__image{left:30%;opacity:.5}.hero__image:before{background:linear-gradient(90deg,#eff9fc 0%,#eff9fce8 32%,#eff9fc50 100%)}.hero__stamp{right:12px;top:12px}.benefits__grid{grid-template-columns:repeat(2,minmax(0,1fr))}.destination-grid,.fleet-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.order{grid-template-columns:1fr}.site-footer__inner{flex-wrap:wrap}}
@media(max-width:600px){.container{width:min(100% - 32px,1350px)}.site-header__inner{padding:13px 16px;gap:10px}.logo{font-size:17px}.logo__image{width:213px}.header-contacts{width:100%;justify-content:space-between;gap:8px}.header-phones a{font-size:15px}.hero{min-height:auto}.hero__content{padding-block:38px 32px;min-height:0}.hero__text{width:100%}.hero__image{inset:0;opacity:.22}.hero__image:before{background:#eff9fbc7}.hero h1{font-size:clamp(34px,8.8vw,49px)}.hero__stamp{display:none}.hero__phone-panel{width:100%;padding:16px}.hero__phone strong{font-size:clamp(38px,10.3vw,56px)}.hero__actions{display:grid}.hero__actions .cta{width:100%}.benefits__grid,.destination-grid,.fleet-grid{grid-template-columns:1fr}.benefits article{padding:17px}.section-heading{display:block}.section-heading>p{margin-top:12px}.destinations{padding-block:30px}.fleet{padding-block:35px}.fleet-card img{height:210px}.request-form__row{grid-template-columns:1fr}.site-footer__inner{display:grid;grid-template-columns:1fr 1fr}.footer-brand{grid-column:1/-1}.price-panel h2 span{white-space:normal}}
@media(max-width:920px){.logo__image{width:228px}}
@media(max-width:600px){.logo__image{width:213px}.footer-brand__image{width:255px}.max-icon{width:36px;height:36px}}
@media(prefers-reduced-motion:reduce){.accessible-taxi{scroll-behavior:auto}}

/* Public landing accessibility and responsive navigation */
.accessible-taxi{overflow-x:clip}
.accessible-taxi section[id],.accessible-taxi #request{scroll-margin-top:110px}
.transport-menu-toggle{display:none;align-items:center;justify-content:center;gap:9px;min-height:44px;padding:9px 13px;background:#fff;color:var(--ink);border:1px solid #9fb0c0;border-radius:10px;font-size:16px;font-weight:800}
.transport-menu-toggle:hover{border-color:var(--blue);background:#f1f8fa}
.header-nav a{font-size:16px}
.benefits__icon,.destination-icon{flex-shrink:0}
.request-form input:focus-visible{outline:3px solid var(--blue);outline-offset:2px}
.request-form small{font-size:16px;line-height:1.55}
.request-form button{width:100%}
@media(max-width:1460px){
  .site-header__inner{flex-wrap:wrap;gap:12px 18px}
  .transport-menu-toggle{display:inline-flex;margin-left:auto}
  .header-nav{display:none;order:5;flex-basis:100%;width:100%;flex-direction:column;align-items:stretch;justify-content:flex-start;gap:0;background:#f5fafc;border:1px solid #dce6eb;border-radius:12px;padding:6px 8px}
  .header-nav--open{display:flex}
  .header-nav a{display:block;min-height:44px;padding:11px 13px;border-radius:8px}
  .header-nav a:hover,.header-nav a:focus-visible{background:#e5f2f5}
  .header-contacts{margin-left:0}
}
@media(max-width:600px){
  .accessible-taxi section[id],.accessible-taxi #request{scroll-margin-top:155px}
  .site-header__inner{align-items:center}
  .transport-menu-toggle{font-size:14px;padding:9px 10px}
  .header-contacts{flex-wrap:wrap}
  .header-phones a{font-size:15px}
  .request-form small{font-size:15px}
}
@media(max-width:380px){
  .logo__image{width:180px}
  .header-phones a{font-size:14px}
}

/* Audit fix: do not allow the mobile menu to compete with the logo for flex space,
   and do not clip long contact links in the footer. */
@media(max-width:600px){
  /* Explicitly reserve space for the toggle; avoid flexible row collisions. */
  .site-header__inner{display:block;position:relative;padding-right:16px}
  .site-header__inner .logo{display:block;width:calc(100% - 120px);min-width:0}
  .site-header__inner .logo__image{width:min(100%,213px);height:auto}
  .site-header__inner .transport-menu-toggle{position:absolute;right:16px;top:12px;z-index:2;display:inline-flex;margin:0}
  .site-header__inner .header-contacts{display:flex;width:100%;min-width:0;margin-top:12px;justify-content:space-between;flex-wrap:wrap}
  .site-header__inner .header-nav{display:none;width:100%;margin-top:10px}
  .site-header__inner .header-nav--open{display:flex}
  .site-footer__inner{grid-template-columns:minmax(0,1fr);gap:22px}
  .site-footer__inner .footer-brand{grid-column:1}
  .site-footer__inner .footer-contact{min-width:0}
  .site-footer__inner .footer-contact a{overflow-wrap:anywhere;word-break:normal}
  .site-footer__inner nav{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
}
</style>