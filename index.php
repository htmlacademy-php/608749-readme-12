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
$title = 'readme: популярное';

$params = get_request_params();
$active_filter = $params['filter'];

$result_content_types = get_content_types($link);
$result_popular_posts = get_popular_posts($link, $active_filter);

// проверка данных
$mysql_error = catch_mysql_error($result_content_types, $result_popular_posts);

if ($mysql_error) {
    $main = include_template('error.php', ['error' => $mysql_error]);
} else {
    $main = include_template('main.php', [
        'posts' => $result_popular_posts,
        'content_types' => $result_content_types,
        'active_filter' => $active_filter,
    ]);
}

// составление layout страницы
$layout = include_template('layout.php', [
    'main' => $main,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

// отрисовка
print($layout);
