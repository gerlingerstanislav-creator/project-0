<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const outcomes = [
    'Превращать бизнес-задачу или частный запрос в понятную концепцию мероприятия.',
    'Собирать бюджет, тайминг, команду, подрядчиков и площадку под заданные ограничения.',
    'Продумывать сценарий, гостевой путь, визуальную среду, контент и механику вовлечения.',
    'Управлять подготовкой: дедлайнами, рисками, коммуникациями, договорами и чек-листами.',
    'Проводить мероприятие на площадке и принимать решения при изменениях в реальном времени.',
    'Подводить итоги по бюджету, качеству, обратной связи и целям заказчика.',
];

const modules = [
    {
        number: '01',
        title: 'Роль event-менеджера и логика проекта',
        duration: '1 неделя',
        result: 'Понимание полного жизненного цикла события и своей зоны ответственности.',
        topics: ['Типы мероприятий и уровни сложности', 'Цели бизнеса, HR, маркетинга и частного заказчика', 'Бриф: аудитория, задача, ограничения, KPI', 'Этапы проекта от идеи до закрывающих документов', 'Зоны ответственности event-менеджера, продюсера и подрядчиков'],
        practice: 'Разобрать 3 разных запроса и превратить каждый в структурированный event-бриф.',
    },
    {
        number: '02',
        title: 'Концепция, идея и программа',
        duration: '1–2 недели',
        result: 'Умение создавать реализуемую концепцию, а не только красивую идею.',
        topics: ['Инсайт аудитории и центральная идея', 'Формат, тема, tone of voice и визуальный образ', 'Драматургия события: вход, развитие, кульминация, финал', 'Механики вовлечения и нетворкинга', 'Сценарный план, программа и тайминг', 'Как защищать концепцию перед заказчиком'],
        practice: 'Разработать 2 концепции под один бриф: рациональную и смелую. Защитить выбор.',
    },
    {
        number: '03',
        title: 'Бюджет и экономика мероприятия',
        duration: '1 неделя',
        result: 'Умение собрать бюджет, не потерять обязательные статьи и удержать финансовую рамку.',
        topics: ['Структура сметы и обязательные статьи', 'Фиксированные и переменные расходы', 'Резерв на риски и непредвиденные затраты', 'Тендер и сравнение предложений подрядчиков', 'Оптимизация без разрушения концепции', 'План-факт и закрытие бюджета'],
        practice: 'Собрать три версии одной сметы: minimum, target и extended.',
    },
    {
        number: '04',
        title: 'Площадка, техника и производство',
        duration: '2 недели',
        result: 'Способность говорить с техническими подрядчиками на одном языке и контролировать монтаж.',
        topics: ['Выбор площадки и технический осмотр', 'Зонирование и гостевые потоки', 'Свет, звук, экраны, сцена, электричество и интернет', 'Декор, навигация, мебель и брендинг', 'Кейтеринг, гардероб, безопасность и клининг', 'Монтаж, саундчек, репетиция и демонтаж'],
        practice: 'Составить технический план площадки и production checklist для события на 150 гостей.',
    },
    {
        number: '05',
        title: 'Подрядчики, команда и документы',
        duration: '1 неделя',
        result: 'Умение собрать рабочую команду и управлять внешними исполнителями.',
        topics: ['Поиск и проверка подрядчиков', 'Техническое задание и критерии приёмки', 'Переговоры, договорённости и фиксация изменений', 'RACI и распределение ролей', 'Брифинг персонала и волонтёров', 'Договоры, акты, права на контент и персональные данные'],
        practice: 'Подготовить ТЗ для ведущего, площадки, кейтеринга и технического подрядчика.',
    },
    {
        number: '06',
        title: 'Гости, коммуникации и сервис',
        duration: '1 неделя',
        result: 'Спроектированный путь гостя от приглашения до сообщения после мероприятия.',
        topics: ['Регистрация и guest list', 'Приглашения, напоминания и информационные сообщения', 'Welcome-зона и навигация', 'VIP, спикеры, артисты и специальные потребности', 'Сервисные стандарты команды', 'Фото, видео, контент и коммуникация после события'],
        practice: 'Спроектировать customer journey гостя с точками контакта и ответственными.',
    },
    {
        number: '07',
        title: 'Риски и проведение мероприятия',
        duration: '2 недели',
        result: 'Готовность управлять площадкой и сохранять контроль, когда план меняется.',
        topics: ['Risk register и план B/C', 'Погода, опоздания, техника, медицина и безопасность', 'Run of show и оперативный штаб', 'Рации, каналы связи и правила эскалации', 'Работа с ведущим, режиссёром, спикерами и артистами', 'Что делать при сбое программы без паники для гостя'],
        practice: 'Провести tabletop-симуляцию: 10 аварийных ситуаций во время одного события.',
    },
    {
        number: '08',
        title: 'Оценка результата и развитие',
        duration: '1 неделя',
        result: 'Умение доказать ценность проведённого события и сделать следующий проект сильнее.',
        topics: ['KPI для внутренних, маркетинговых и частных мероприятий', 'Обратная связь гостей и заказчика', 'Фактический бюджет и отклонения', 'Разбор команды: что сработало и что изменить', 'Отчёт, медиаматериалы и закрывающие документы', 'Портфолио event-менеджера и база проверенных подрядчиков'],
        practice: 'Подготовить post-event report с выводами и планом улучшений.',
    },
];

const projects = [
    { level: 'Уровень 1', title: 'Камерное внутреннее событие', scale: '20–50 гостей', examples: 'Квиз, welcome-встреча, мастер-класс, командный вечер.', goal: 'Самостоятельно пройти весь цикл с ограниченным бюджетом и простой логистикой.' },
    { level: 'Уровень 2', title: 'Корпоративное мероприятие', scale: '80–250 гостей', examples: 'Летний праздник, конференция, новогоднее мероприятие, team day.', goal: 'Управлять площадкой, несколькими подрядчиками, сценарием, техникой и командой.' },
    { level: 'Уровень 3', title: 'Сложный внешний или частный проект', scale: '150+ гостей / несколько зон', examples: 'Форум, клиентское событие, большой праздник, свадьба или городской формат.', goal: 'Работать с высокой ценой ошибки, сложным продакшеном, рисками и параллельными потоками.' },
];

const competencies = [
    ['Концепция', 'Есть идея', 'Идея связана с задачей и аудиторией', 'Концепция выдерживает ограничения и имеет сценарную логику'],
    ['Бюджет', 'Собирает базовую смету', 'Управляет вариантами и резервом', 'Оптимизирует сложную смету без потери результата'],
    ['Продакшен', 'Работает по чек-листу', 'Самостоятельно координирует площадку и подрядчиков', 'Управляет многозонным техническим продакшеном'],
    ['Проведение', 'Ведёт небольшой event', 'Управляет штабом и run of show', 'Стабильно принимает решения в кризисных ситуациях'],
    ['Коммуникация', 'Фиксирует задачи', 'Ведёт заказчика и команду', 'Управляет ожиданиями нескольких стейкхолдеров'],
];
</script>

<template>
    <Head title="Обучение event-менеджера" />

    <AppLayout>
        <div class="event-training">
            <section class="event-hero">
                <div>
                    <p class="event-kicker">10 / EVENT MANAGEMENT</p>
                    <h1>Программа обучения<br><span>event-менеджера</span></h1>
                    <p class="event-hero__lead">Практический маршрут от первого брифа до самостоятельного проведения мероприятий разной сложности — внутри компании и для частных заказчиков.</p>
                </div>
                <div class="event-hero__stats">
                    <div><strong>12–14</strong><span>недель</span></div>
                    <div><strong>8</strong><span>модулей</span></div>
                    <div><strong>3</strong><span>практических проекта</span></div>
                </div>
            </section>

            <section class="event-section event-outcome">
                <div class="event-section__heading"><span>Результат</span><h2>Что специалист должен уметь после обучения</h2></div>
                <div class="event-outcome__grid">
                    <article v-for="(item, index) in outcomes" :key="item" class="event-outcome__item"><span>0{{ index + 1 }}</span><p>{{ item }}</p></article>
                </div>
            </section>

            <section class="event-section">
                <div class="event-section__heading"><span>Учебный маршрут</span><h2>8 модулей от идеи до пост-анализа</h2></div>
                <div class="event-modules">
                    <article v-for="module in modules" :key="module.number" class="event-module">
                        <div class="event-module__index"><strong>{{ module.number }}</strong><span>{{ module.duration }}</span></div>
                        <div class="event-module__body">
                            <h3>{{ module.title }}</h3>
                            <p class="event-module__result">{{ module.result }}</p>
                            <ul><li v-for="topic in module.topics" :key="topic">{{ topic }}</li></ul>
                            <div class="event-practice"><span>Практика</span><p>{{ module.practice }}</p></div>
                        </div>
                    </article>
                </div>
            </section>

            <section class="event-section event-lab">
                <div class="event-section__heading"><span>Практика</span><h2>Три проекта с растущей сложностью</h2></div>
                <div class="event-projects">
                    <article v-for="project in projects" :key="project.level" class="event-project">
                        <div class="event-project__top"><span>{{ project.level }}</span><strong>{{ project.scale }}</strong></div>
                        <h3>{{ project.title }}</h3>
                        <p>{{ project.examples }}</p>
                        <div class="event-project__goal"><span>Цель</span>{{ project.goal }}</div>
                    </article>
                </div>
            </section>

            <section class="event-section">
                <div class="event-section__heading"><span>Рабочая система</span><h2>Документы, которые выпускник должен уметь собирать</h2></div>
                <div class="event-toolkit">
                    <span>Event-бриф</span><span>Концепт-презентация</span><span>Смета</span><span>Календарный план</span><span>RACI</span><span>ТЗ подрядчикам</span><span>План площадки</span><span>Run of show</span><span>Guest list</span><span>Risk register</span><span>Монтажный план</span><span>Чек-лист открытия</span><span>Post-event report</span><span>План-факт бюджета</span>
                </div>
            </section>

            <section class="event-section">
                <div class="event-section__heading"><span>Контроль навыков</span><h2>Матрица роста специалиста</h2></div>
                <div class="event-table-wrap">
                    <table class="event-table">
                        <thead><tr><th>Навык</th><th>Junior</th><th>Самостоятельный</th><th>Сложные проекты</th></tr></thead>
                        <tbody><tr v-for="row in competencies" :key="row[0]"><th>{{ row[0] }}</th><td>{{ row[1] }}</td><td>{{ row[2] }}</td><td>{{ row[3] }}</td></tr></tbody>
                    </table>
                </div>
            </section>

            <section class="event-final">
                <div>
                    <p class="event-kicker">ФИНАЛЬНАЯ АТТЕСТАЦИЯ</p>
                    <h2>Не тест, а реальное мероприятие</h2>
                    <p>Выпускник получает бриф, самостоятельно создаёт концепцию, защищает бюджет и план, организует подготовку, проводит событие и сдаёт post-event report. Курс считается пройденным, когда специалист способен объяснить каждое своё решение и провести проект без постоянного операционного сопровождения наставника.</p>
                </div>
                <div class="event-final__criteria"><span>Концепция</span><span>Бюджет</span><span>Продакшен</span><span>Сервис</span><span>Риски</span><span>Проведение</span><span>Результат</span></div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
.event-training{max-width:1260px;margin:0 auto;padding:18px 18px 72px;color:#271d2f}.event-hero{display:grid;grid-template-columns:minmax(0,1.7fr) minmax(280px,.7fr);gap:40px;align-items:end;padding:64px clamp(28px,5vw,72px);border-radius:30px;background:linear-gradient(145deg,#1f1728 0%,#352141 55%,#593468 100%);color:#fff;box-shadow:0 26px 70px #311c3d26}.event-kicker{margin:0 0 20px;color:#dcbfe8;font-size:12px;font-weight:800;letter-spacing:.16em}.event-hero h1{margin:0;font-size:clamp(42px,6vw,76px);line-height:.97;letter-spacing:-.055em}.event-hero h1 span{color:#e8bdf2}.event-hero__lead{max-width:760px;margin:26px 0 0;color:#e7dce9;font-size:18px;line-height:1.65}.event-hero__stats{display:grid;gap:10px}.event-hero__stats div{display:flex;align-items:baseline;justify-content:space-between;gap:16px;padding:18px 0;border-bottom:1px solid #ffffff24}.event-hero__stats strong{font-size:34px}.event-hero__stats span{color:#d7c8dc;font-size:13px}.event-section{padding:68px 4px 0}.event-section__heading{display:grid;grid-template-columns:170px minmax(0,1fr);gap:20px;align-items:start;margin-bottom:28px}.event-section__heading>span{text-transform:uppercase;color:#9b7aa8;font-size:11px;font-weight:800;letter-spacing:.14em;padding-top:9px}.event-section__heading h2{margin:0;max-width:800px;font-size:clamp(30px,4vw,48px);line-height:1.05;letter-spacing:-.045em}.event-outcome__grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.event-outcome__item{display:flex;gap:18px;min-height:126px;padding:24px;border:1px solid #e9e1ec;border-radius:18px;background:#fff}.event-outcome__item span{color:#ad8ab9;font-size:12px;font-weight:800}.event-outcome__item p{margin:0;font-size:16px;line-height:1.55}.event-modules{display:grid;gap:14px}.event-module{display:grid;grid-template-columns:150px minmax(0,1fr);overflow:hidden;border:1px solid #e7deea;border-radius:22px;background:#fff}.event-module__index{display:flex;flex-direction:column;justify-content:space-between;padding:28px;border-right:1px solid #eee7f0;background:#faf7fb}.event-module__index strong{color:#9b6bab;font-size:34px}.event-module__index span{color:#8a7a8e;font-size:12px}.event-module__body{padding:28px 32px}.event-module h3{margin:0;font-size:24px;letter-spacing:-.025em}.event-module__result{margin:8px 0 20px;color:#766b7a;line-height:1.55}.event-module ul{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px 30px;margin:0;padding-left:20px;color:#4d4450;line-height:1.45}.event-practice{display:grid;grid-template-columns:110px minmax(0,1fr);gap:10px;margin-top:22px;padding:16px 18px;border-radius:12px;background:#f4edf6}.event-practice span{color:#8f649d;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em}.event-practice p{margin:0;line-height:1.45}.event-projects{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}.event-project{padding:26px;border:1px solid #e6dce9;border-radius:20px;background:#fff}.event-project__top{display:flex;justify-content:space-between;gap:10px;color:#9a75a6;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em}.event-project h3{margin:34px 0 10px;font-size:22px}.event-project>p{min-height:48px;margin:0;color:#776c7b;font-size:14px;line-height:1.55}.event-project__goal{margin-top:22px;padding-top:18px;border-top:1px solid #eee7f0;color:#4d4450;font-size:14px;line-height:1.55}.event-project__goal span{display:block;margin-bottom:6px;color:#9a75a6;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em}.event-toolkit{display:flex;flex-wrap:wrap;gap:9px}.event-toolkit span{padding:10px 13px;border:1px solid #ddcfe2;border-radius:999px;background:#fff;color:#55495a;font-size:13px}.event-table-wrap{overflow:auto;border:1px solid #e4dbe7;border-radius:18px;background:#fff}.event-table{width:100%;min-width:780px;border-collapse:collapse}.event-table th,.event-table td{padding:17px 18px;border-bottom:1px solid #eee8f0;text-align:left;vertical-align:top;font-size:13px;line-height:1.45}.event-table thead th{background:#f7f2f8;color:#77627d;font-size:11px;text-transform:uppercase;letter-spacing:.08em}.event-table tbody th{width:150px;color:#372d3b}.event-table tbody tr:last-child th,.event-table tbody tr:last-child td{border-bottom:0}.event-final{display:grid;grid-template-columns:minmax(0,1.4fr) minmax(250px,.6fr);gap:36px;margin-top:72px;padding:46px;border-radius:26px;background:#27202d;color:#fff}.event-final h2{margin:0;font-size:clamp(30px,4vw,48px);letter-spacing:-.04em}.event-final p:not(.event-kicker){max-width:760px;margin:18px 0 0;color:#ded3e1;line-height:1.65}.event-final__criteria{display:flex;flex-wrap:wrap;align-content:start;gap:8px}.event-final__criteria span{padding:9px 11px;border:1px solid #ffffff22;border-radius:999px;background:#ffffff0c;color:#e7dce9;font-size:12px}@media(max-width:900px){.event-hero{grid-template-columns:1fr}.event-hero__stats{grid-template-columns:repeat(3,1fr)}.event-hero__stats div{display:block}.event-hero__stats span{display:block;margin-top:4px}.event-projects{grid-template-columns:1fr}.event-project>p{min-height:0}.event-final{grid-template-columns:1fr}}@media(max-width:680px){.event-training{padding:8px 8px 44px}.event-hero{padding:38px 24px;border-radius:22px}.event-hero__lead{font-size:16px}.event-hero__stats{grid-template-columns:1fr}.event-hero__stats div{display:flex}.event-section{padding-top:48px}.event-section__heading{grid-template-columns:1fr;gap:6px}.event-section__heading>span{padding-top:0}.event-outcome__grid{grid-template-columns:1fr}.event-module{grid-template-columns:1fr}.event-module__index{flex-direction:row;border-right:0;border-bottom:1px solid #eee7f0}.event-module__body{padding:24px}.event-module ul{grid-template-columns:1fr}.event-practice{grid-template-columns:1fr}.event-final{margin-top:50px;padding:30px 24px;border-radius:22px}}
</style>
