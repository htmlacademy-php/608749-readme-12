<?php

// импорты
require_once 'user-functions.php';
require_once 'helpers.php';
require_once 'models.php';
require_once 'config/db.php';

// объявления переменной
$link = init($db);
$result_content_types = get_content_types($link);
$result_popular_posts = get_popular_posts($link);
$is_auth = rand(0, 1);
$user_name = 'Тина Кузьменко';
$title = 'readme: популярное';

// проверяем все ли в порядке с данными
$mysql_error = catch_mysql_error($result_content_types, $result_popular_posts);

if ($mysql_error) {
    $main = include_template('error.php', ['error' => $mysql_error]);
    die();
}

// передаем данные в шаблон
$main = include_template('main.php', [
    'posts' => $result_popular_posts,
    'content_types' => $result_content_types,
]);

// составляем template страницы
$layout = include_template('layout.php', [
    'main' => $main,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

// отрисовываем
print($layout);
