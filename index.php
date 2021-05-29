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

// получаем параметры из строки запроса
$params = [
    'filter' => filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_NUMBER_INT) ?? 0,
    'sort' => filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_STRING) ?? 'views',
    'direction' => filter_input(INPUT_GET, 'direction', FILTER_SANITIZE_STRING) ?? 'desc'
];

function build_query($params) {
    $scriptname = pathinfo(__FILE__, PATHINFO_BASENAME);
    $query = http_build_query($params);

    return "/" . $scriptname . "?" . $query;
}

// получаем данные
$result_content_types = get_content_types($link);
$result_popular_posts = get_popular_posts($link, $params);

// проверка данных
$mysql_error = catch_mysql_error($result_content_types, $result_popular_posts);

// массив с подготовленными постами для главной
$prepared_posts = [];

// собираем все данные для поста
if (!empty($result_popular_posts)) {
    foreach ($result_popular_posts as $post) {
        $likes = get_likes($link, $post['id']);
        $comments = get_post_comments($link, $post['id']);
        $prepared_posts[] = array_merge($post, $likes[0], ['comments' => count($comments)]);
    }
}

// получаем шаблон для main
$main = $mysql_error
    ? include_template('db-error.php', ['error' => $mysql_error])
    : include_template('main.php', [
        'posts' => $prepared_posts,
        'content_types' => $result_content_types,
        'active_filter' => intval($params['filter']),
        'active_sort' => $params['sort'],
        'sort_direction' => $params['direction'],
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
