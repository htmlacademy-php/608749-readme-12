<?php

require_once 'user-functions.php';
require_once 'helpers.php';
require_once 'config/db.php';

$result_content_types = [];
$result_popular_posts = [];
$main = '';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

if (!$link) {
    $error = mysqli_connect_error();
    $main = include_template('error.php', ['error' => $error]);
} else {
    mysqli_set_charset($link, "utf8");
}
