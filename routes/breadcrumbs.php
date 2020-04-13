<?php

if (!Breadcrumbs::exists('home')) {
    Breadcrumbs::for('home', function ($trail) {
        $trail->push('Домашняя страница', route('home'));
    });
}

if (!Breadcrumbs::exists('profile')) {
    Breadcrumbs::for('profile', function ($trail) {
        $trail->parent('home');
        $trail->push('Профиль', route('profile'));
    });
}

if (!Breadcrumbs::exists('profile.edit')) {
    Breadcrumbs::for('profile.edit', function ($trail) {
        $trail->parent('profile');
        $trail->push('Настройка профиля', route('profile.edit'));
    });
}

if (!Breadcrumbs::exists('profile.edit.token')) {
    Breadcrumbs::for('profile.edit.token', function ($trail) {
        $trail->parent('profile');
        $trail->push('Настройка токена', route('profile.edit.token'));
    });
}


if (!Breadcrumbs::exists('server')) {
    Breadcrumbs::for('server', function ($trail) {
        $trail->parent('home');
        $trail->push('Список серверов', route('server'));
    });
}

if (!Breadcrumbs::exists('server.add')) {
    Breadcrumbs::for('server.add', function ($trail) {
        $trail->parent('server');
        $trail->push('Добавление сервера', route('server.add'));
    });
}

if (!Breadcrumbs::exists('server.edit')) {
    Breadcrumbs::for('server.edit', function ($trail, $id) {
        $trail->parent('server');
        $trail->push('Изменение сервера', route('server.edit', ['id' => $id]));
    });
}

if (!Breadcrumbs::exists('server.console')) {
    Breadcrumbs::for('server.console', function ($trail, $id) {
        $trail->parent('server');
        $trail->push('Консоль сервера', route('server.console', ['id' => $id]));
    });
}

if (!Breadcrumbs::exists('server.logs')) {
    Breadcrumbs::for('server.logs', function ($trail, $id) {
        $trail->parent('server');
        $trail->push('Логи запросов', route('server.logs', ['id' => $id]));
    });
}

if (!Breadcrumbs::exists('server.logs.date')) {
    Breadcrumbs::for('server.logs.date', function ($trail, $data) {
        $trail->parent('server');
        $trail->push($data['date'], route('server.logs.date', [
            'id' => $data['id'],
            'date' => $data['date']
        ]));
    });
}


if (!Breadcrumbs::exists('server.scripts')) {
    Breadcrumbs::for('server.scripts', function ($trail, $server_id) {
        $trail->parent('server');
        $trail->push('Список команд', route('server.scripts', ['server_id' => $server_id]));
    });
}

if (!Breadcrumbs::exists('server.scripts.add')) {
    Breadcrumbs::for('server.scripts.add', function ($trail, $server_id) {
        $trail->parent('server.scripts', $server_id);
        $trail->push('Добавление команды', route('server.scripts.add', ['server_id' => $server_id]));
    });
}

if (!Breadcrumbs::exists('server.scripts.edit')) {
    Breadcrumbs::for('server.scripts.edit', function ($trail, $server_id, $script_id) {
        $trail->parent('server.scripts', $server_id);
        $trail->push('Изменение команды', route('server.scripts.edit', ['server_id' => $server_id, 'script_id' => $script_id]));
    });
}