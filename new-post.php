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

$form_validation = [
    'text' => validate_text_post(),
    'quote' => validate_quote_post(),
    'video' => validate_video_post(),
    'photo' => validate_photo_post(),
    'link' => validate_link_post(),
];

// получаем данные
$result_content_types = get_content_types($link);
$active_type = $_POST['active-type'] ?? filter_input(INPUT_GET, 'type') ?? 'text';
$values = isset($_POST) && !empty($_POST) ? $_POST : [];

// проверка данных формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = $form_validation[$active_type];

    if (empty($errors)) {
        $post_id = set_post($link, $active_type, $values);

        if (isset($values['post-tags'])) {
            $hashtags = array_unique(explode(' ', $values['post-tags']));

            foreach ($hashtags as $hashtag) {
                $tag = substr($hashtag, 1);
                set_post_tag($link, $post_id, $tag);
            }
        }

         $URL = '/post.php?id=' . $post_id;
         header("Location: $URL");
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
        'form_title' => $form_titles[$active_type] ?? $form_titles['text'],
        'errors' => $errors,
        'values' => $values,
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
