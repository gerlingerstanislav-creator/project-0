# STools

**STools** — веб-приложение на Laravel 13 с небольшими инструментами в едином SPA-интерфейсе.

## Возможности

В боковом меню доступны пять разделов:

1. **Идеи стартапов** — список идей из SQLite. Роли **admin** и **editor** могут редактировать название и описание.
2. **Степан, выпей** — интерактивная мини-игра со стаканом на четыре глотка.
3. **Инструмент 3** — каркас третьего инструмента.
4. **Менеджерские шпаргалки** — материалы из базы данных в раскрывающихся карточках.
5. **Горнолыжные курорты** — /ski-resort с погодой, прогнозом и веб-камерами пяти российских курортов.

Публичный вход находится на /login. Просмотр основных разделов доступен без авторизации, а редактирование идей и управление push-подпиской требуют авторизации.

### Горнолыжные курорты

Доступны:

- Шерегеш;
- Красная Поляна;
- Роза Хутор;
- Газпром (Лаура + Альпика);
- Большой Вудъявр (Кировск).

Погода загружается из Open-Meteo в браузере. Камеры поддерживают официальные видео-плееры, изображения и внешние страницы камер.

## Архитектура

Frontend построен на **Inertia.js + Vue 3**:

- Laravel отвечает за маршруты, авторизацию, данные и серверные mutations.
- Inertia передаёт страницы и props без отдельного frontend API.
- Vue-компоненты находятся в resources/js/pages/.
- Общий интерфейс находится в resources/js/components/.
- Точка входа frontend — resources/js/app.js.
- Стили — resources/css/app.css.
- Vite собирает production frontend.

Для будущих push-уведомлений уже подготовлена PWA-основа:

- public/site.webmanifest;
- public/sw.js;
- resources/js/pwa.js;
- модель и миграция PushSubscription;
- защищённые endpoints /push/subscriptions.

Автоматический запрос разрешения на уведомления пока не выполняется. Для полноценной отправки push ещё нужны VAPID-ключи и серверный web-push sender.

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
- resources/js/components/ — общие Vue-компоненты.
- resources/js/ — frontend entry и сервисные модули.
- resources/css/ — стили.
- resources/views/app.blade.php — минимальный Laravel shell для Inertia.
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

Push в main запускает GitHub Actions:

1. PHP 8.5 и PHPUnit.
2. Node.js 22 и production-сборку Vite.
3. Упаковку release-архива.
4. Деплой на Ubuntu VPS после успешных проверок.
5. HTTP health check /up.
6. Telegram-уведомление при ошибке push-деплоя.

Деплой выполняется из release-архива и не переносит локальные .env, SQLite-базу, vendor или node_modules.

Подробные правила разработки и диагностики CI находятся в AGENTS.md.
