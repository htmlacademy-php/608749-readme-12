<?php

// импорты
require_once 'user-functions.php';
require_once 'helpers.php';
require_once 'new-post-validation.php';
require_once 'models.php';
require_once 'config/db.php';

// получение mysqli объекта для работы с базой данных
$link = init($db);

// объявление переменных
$is_auth = rand(0, 1);
$user_name = 'Тина Кузьменко';
$title = 'readme: добавить публикацию';
$mysql_error = '';
$errors = [];

$form_titles = [
    'text' => 'Форма добавления текста',
    'quote' => 'Форма добавления цитаты',
    'video' => 'Форма добавления видео',
    'photo' => 'Форма добавления фото',
    'link' => 'Форма добавления ссылки',
];

// получаем данные
$result_content_types = get_content_types($link);

$active_type = isset($_POST['active-type']) ? $_POST['active-type'] : filter_input(INPUT_GET, 'type') ?? 'text';

// проверка данных формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = validate_active_form($active_type, $_POST);

    if (empty($errors)) {

        // @todo делаем запрос на добавление поста в БД
        // @todo делаем запрос на добавление тэгов в БД

        // $URL = '/post.php?id=' . $post_id;
        // header("Location: $URL");
    }
}

// проверка данных
$mysql_error = catch_mysql_error($result_content_types);

// получаем шаблон для main
$main = $mysql_error
    ? include_template('db-error.php', ['error' => $mysql_error])
    : include_template('add-post.php', [
        'content_types' => $result_content_types,
        'active_type' => isset($form_titles[$active_type]) ? $active_type : 'error',
        'form_title' => isset($form_titles[$active_type]) ? $form_titles[$active_type] : $form_titles['text'],
        'errors' => $errors,
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
