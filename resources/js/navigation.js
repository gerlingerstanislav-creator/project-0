export const appLinks = [
    { href: '/', label: 'Главная', number: '0', guest: true, auth: true },
    { href: '/tool-1', label: 'Идеи стартапов', number: '1', auth: true },
    { href: '/tool-2', label: 'Степан, выпей', number: '2', auth: true },
    { href: '/tool-3', label: 'Инструмент 3', number: '3', auth: true },
    { href: '/manager-cheat-sheets', label: 'Менеджерские шпаргалки', number: '4', auth: true },
    { href: '/ski-resort', label: 'Горнолыжные курорты', number: '5', auth: true },
    { href: '/news', label: 'Новости', number: '6', auth: true },
    { href: '/tests', label: 'Тесты', number: '7', auth: true },
    { href: '/cron-scheduler', label: 'Конструктор расписаний', number: '8', auth: true },
    { href: '/design-system', label: 'Дизайн-система', number: '9', auth: true, roles: ['admin', 'moderator'] },
    { href: '/login', label: 'Войти', number: '→', guest: true },
];