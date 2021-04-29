<?php

require_once 'init.php';
require_once 'user-functions.php';
require_once 'helpers.php';

if (!$link) {
    $error = mysqli_connect_error();
    $main = include_template('error.php', ['error' => $error]);
} else {
    $sql_content_types = 'SELECT type, icon FROM content_type';
    $result_content_types = mysqli_query($link, $sql_content_types);

    $sql_popular_posts =
        'SELECT p.id, date, title, content, cite_author, views, login, icon, avatar
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        ORDER BY views DESC LIMIT 6';
    $result_popular_posts = mysqli_query($link, $sql_popular_posts);

    $content_types = mysqli_fetch_all($result_content_types, MYSQLI_ASSOC);
    $popular_posts = mysqli_fetch_all($result_popular_posts, MYSQLI_ASSOC);

    if (!$result_content_types || !$result_popular_posts) {
        $error = mysqli_error($link);
        $main = include_template('error.php', ['error' => $error]);
    }
}

$is_auth = rand(0, 1);

$user_name = 'Тина Кузьменко';

$title = 'readme: популярное';

$main = include_template('main.php', [
    'posts' => $result_popular_posts,
    'content_types' => $result_content_types,
]);

$layout = include_template('layout.php', [
    'main' => $main,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout);
