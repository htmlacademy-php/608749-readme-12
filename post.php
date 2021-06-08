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
$post = [];

$params = [
    'id' => filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? 0,
];

$result_post = get_post_details($link, $params['id']);
$result_hashtags = get_post_hashtags($link, $params['id']);
$result_comments = get_post_comments($link, $params['id']);

// проверка данных
$mysql_error = catch_mysql_error($result_post, $result_hashtags, $result_comments);

// запрос данных о пользователе
if (!$mysql_error && !empty($result_post)) {
    $user_id = $result_post[0]['user_id'];
    $result_user = get_user($link, $user_id)[0];
    $user_subscribers = get_subscribers_amount($link, $user_id)[0];
    $user_posts = get_posts_amount($link, $user_id)[0];
}

// получаем шаблон для main
if (empty($result_post) || !$result_post) {
    $main = include_template('errors/not-found.php', [ 'error' => $mysql_error, ]);
} else {
    $likes = get_likes($link, $result_post[0]['id']);
    $post = array_merge($result_post[0], ...$likes);

    $main = $mysql_error
        ? include_template('errors/db-error.php', ['error' => $mysql_error])
        : include_template('post-details.php', [
            'post' => $post,
            'hashtags' => $result_hashtags,
            'comments' => $result_comments,
            'user' => $result_user,
            'user_posts' => $user_posts['posts'],
            'user_subscribers' => $user_subscribers['subscribers'],
    ]);
}

// составление layout страницы
$layout = include_template('layout.php', [
    'main' => $main,
    'title' => !empty($post) ? 'readme: ' .  $post['title'] : 'readme: Unknown page',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

// отрисовка
print($layout);
