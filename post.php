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

$params = [
    'id' => filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? 0,
];

$result_post = get_post_details($link, $params['id']);

// проверка данных
$mysql_error = catch_mysql_error($result_post);

// получаем шаблон для main
if (empty($result_post)) {
    $main = include_template('errors/not-found.php');
} else {
    $main = $mysql_error
        ? include_template('errors/db-error.php', ['error' => $mysql_error])
        : include_template('post-details.php', [
            'post' => $result_post[0],
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
