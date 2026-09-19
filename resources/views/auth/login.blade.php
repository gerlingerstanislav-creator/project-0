<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>Авторизация — Инструменты</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-page">
    <main class="auth-card">
        <p class="page__eyebrow">Tools</p>
        <h1>Авторизация</h1>
        <p class="auth-card__description">Войди в аккаунт, чтобы продолжить работу с инструментами.</p>

        @if ($errors->any())
            <div class="auth-card__error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('login.store') }}">
            @csrf

            <label class="auth-form__label" for="username">Логин</label>
            <input
                class="auth-form__input"
                id="username"
                name="username"
                type="text"
                value="{{ old('username') }}"
                autocomplete="username"
                required
                autofocus
            >

            <label class="auth-form__label" for="password">Пароль</label>
            <input
                class="auth-form__input"
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
            >

            <button class="auth-form__submit" type="submit">Войти</button>
        </form>
    </main>
</body>
</html>
