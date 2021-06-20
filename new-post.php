<?php

// импорты
require_once 'user-functions.php';
require_once 'helpers.php';
require_once 'models.php';
require_once 'config/db.php';

// получение mysqli объекта для работы с базой данных
$link = init($db);

// объявление переменных
$is_auth = rand(0, 1);
$user_name = 'Тина Кузьменко';
$title = 'readme: добавить публикацию';
$mysql_error = '';

// получаем параметры из строки запроса
$params = [
    'active_type' => filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING) ?? 'text',
];

// получаем данные
$result_content_types = get_content_types($link);

// проверка данных
$mysql_error = catch_mysql_error($result_content_types);

// получаем шаблон для main
$main = $mysql_error
    ? include_template('db-error.php', ['error' => $mysql_error])
    : include_template('add-post.php', [
        'content_types' => $result_content_types,
        'active_type' => $params['active_type'],
    ]);

// составление layout страницы
$layout = include_template('layout.php', [
    'main' => $main,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

// отрисовка
print($layout);
