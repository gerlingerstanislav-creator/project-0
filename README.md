# project-0

**project-0** — веб-приложение на Laravel 13 с небольшими инструментами в едином SPA-интерфейсе.

**Сайт:** https://project-0.duckdns.org

## Доступ и авторизация

Главная страница `/` доступна без авторизации и содержит приветственное сообщение со ссылкой на вход. Все инструменты, тесты, дизайн-система и push-endpoints защищены middleware `auth`.

В системе три роли: **admin**, **moderator** и **user**. Администратор и модератор могут редактировать идеи стартапов. Начальный пользователь `user` создаётся сидером с паролем `12345678`.

## Возможности

После авторизации в боковом меню доступны шесть разделов:

1. **Идеи стартапов** — список идей из SQLite. Роли **admin** и **editor** могут редактировать название и описание.
2. **Степан, выпей** — интерактивная мини-игра со стаканом на четыре глотка.
3. **Инструмент 3** — каркас третьего инструмента.
4. **Менеджерские шпаргалки** — материалы из базы данных в раскрывающихся карточках.
5. **Горнолыжные курорты** — /ski-resort с погодой, прогнозом и веб-камерами пяти российских курортов.
6. **Тесты** — /tests для проверки PWA и push-уведомлений; сама страница публична, отправка тестового push требует авторизации.

Публичные страницы — только `/` и `/login`. Остальные разделы требуют авторизации.

### Горнолыжные курорты

Доступны:

- Шерегеш;
- Красная Поляна;
- Роза Хутор;
- Газпром (Лаура + Альпика);
- Большой Вудъявр (Кировск).

Погода загружается из Open-Meteo в браузере. Камеры поддерживают официальные видео-плееры, изображения и внешние страницы камер.

## Архитектура

Frontend построен на **Inertia.js + Vue 3** и все пользовательские страницы рендерятся как Inertia/Vue-компоненты; Blade используется только как минимальный HTML-shell:

- Laravel отвечает за маршруты, авторизацию, данные и серверные mutations.
- Inertia передаёт страницы и props без отдельного frontend API.
- Vue-компоненты находятся в resources/js/pages/.
- Общий интерфейс находится в resources/js/layouts/.
- Точка входа frontend — resources/js/app.js.
- Стили — resources/css/app.css.
- Vite собирает production frontend.

### Design system

Интерфейс использует внутреннюю дизайн-систему на базе semantic design tokens и переиспользуемых Vue-компонентов. Основные компоненты находятся в `resources/js/components/ui/`, токены и базовые стили — в `resources/css/design-system/`. Каталог компонентов доступен на `/design-system`. При создании или изменении интерфейса сначала используй существующие компоненты и токены, а новые повторяющиеся паттерны выноси в дизайн-систему.

PWA и Web Push уже реализованы:

- public/site.webmanifest;
- public/sw.js;
- resources/js/pwa.js;
- модель и миграция PushSubscription;
- защищённые endpoints /push/subscriptions.

Разрешение на уведомления запрашивается по действию пользователя. Production-деплой автоматически генерирует VAPID-ключи на VPS, если они ещё не заданы, а серверный Web Push sender отправляет уведомления через Minishlink WebPush.

## Стек

- Laravel 13
- PHP 8.3+; CI и production — PHP 8.5
- Inertia.js 3 + Vue 3
- Vite 7
- Tailwind CSS 4
- SQLite
- PHPUnit 12
- GitHub Actions
- Ubuntu VPS + Nginx + PHP-FPM

## Структура

- app/Http/Controllers/ — контроллеры.
- app/Http/Middleware/ — middleware.
- app/Models/ — Eloquent-модели.
- database/migrations/ — схема БД.
- database/seeders/ — начальные данные.
- resources/js/pages/ — Inertia/Vue страницы.
- resources/js/layouts/ — общий layout приложения.
- resources/js/ — frontend entry и сервисные модули.
- resources/css/ — стили.
- resources/views/app.blade.php — минимальный Laravel shell для Inertia; отдельные Blade-страницы приложения не используются.
- routes/web.php — именованные веб-маршруты.
- tests/Feature/ — feature-тесты.
- .github/workflows/ci.yml — тестирование, сборка, release и deploy.
- AGENTS.md — правила разработки и сопровождения проекта.

## Локальный запуск

Установить зависимости:

~~~bash
composer install
npm install
~~~

Подготовить окружение и SQLite:

~~~bash
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
~~~

Запустить dev-сервер frontend:

~~~bash
npm run dev
~~~

Production-сборка:

~~~bash
npm run build
~~~

Тесты:

~~~bash
vendor/bin/phpunit
~~~

## CI/CD

Push в main запускает GitHub Actions. Feature-тесты учитывают текущую модель доступа: защищённые разделы проверяются как для гостя, так и для авторизованного пользователя.

Push в main запускает GitHub Actions:

1. PHP 8.5 и PHPUnit.
2. Node.js 22 и production-сборку Vite.
3. Упаковку release-архива.
4. Деплой на Ubuntu VPS после успешных проверок.
5. HTTP health check /up.
6. Telegram-уведомление при ошибке push-деплоя.

Деплой выполняется из release-архива и не переносит локальные .env, SQLite-базу, vendor или node_modules.

Подробные правила разработки и диагностики CI находятся в AGENTS.md.
