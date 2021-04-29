<?php

require_once 'user-functions.php';
require_once 'config/db.php';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

$result_content_types = [];
$result_popular_posts = [];
$main = '';
