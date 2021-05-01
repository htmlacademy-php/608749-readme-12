<?php

// импорты
require_once 'user-functions.php';
require_once 'helpers.php';
require_once 'init.php';

$sql_content_types = 'SELECT type, icon FROM content_type';
$result_content_types = mysqli_query($link, $sql_content_types);

$sql_popular_posts =
    'SELECT p.id, date, title, content, cite_author, views, login, icon, avatar
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        ORDER BY views DESC
        LIMIT 6';
$result_popular_posts = mysqli_query($link, $sql_popular_posts);

$content_types = mysqli_fetch_all($result_content_types, MYSQLI_ASSOC);
$popular_posts = mysqli_fetch_all($result_popular_posts, MYSQLI_ASSOC);

if (!$content_types || !$popular_posts) {
    $error = mysqli_error($link);
    $main = include_template('error.php', ['error' => $error]);
} else {
    $main = include_template('main.php', [
        'posts' => $result_popular_posts,
        'content_types' => $result_content_types,
    ]);
}

$is_auth = rand(0, 1);
$user_name = 'Тина Кузьменко';
$title = 'readme: популярное';

// составляем template страницы
$layout = include_template('layout.php', [
    'main' => $main,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

// отрисовываем
print($layout);
