<?php

/**
 * Функция для выбора подходящей валидации для той или иной активной формы
 * @param string $active_type   Тип активной формы
 */
function validate_active_form($active_type, $data) {
    switch ($active_type) {
        case 'quote':
            return validate_quote();
        case 'video':
            return validate_video($data);
        case 'photo':
            return validate_photo($data);
        case 'link':
            return validate_link($data);
        case 'text':
        default:
            return validate_text_post();
    }
}

/**
 * Валидация формы текстового поста
 * @return array    массив с ошибками
 */
function validate_text_post() {
    $errors = [];

    if (check_required('text-heading')) {
        $errors = array_merge($errors, ['text-heading' => [
            'title' => 'Заголовок',
            'description' => check_required('text-heading'),
        ]]);
    }

    if (check_required('text-heading')) {
        $errors = array_merge($errors, ['post-text' => [
            'title' => 'Текст поста',
            'description' => check_required('post-text'),
        ]]);
    }

    // @todo валидация тегов
    return $errors;
}

function validate_quote() {
    $errors = [];

    if (check_required('text-heading')) {
        $errors = array_merge($errors, ['text-heading' => [
            'title' => 'Заголовок',
            'description' => check_required('text-heading'),
        ]]);
    }

    if (check_required('cite-text')) {
        $errors = array_merge($errors, ['cite-text' => [
            'title' => 'Текст цитаты',
            'description' => check_required('cite-text'),
        ]]);
    }

    if (check_required('quote-author')) {
        $errors = array_merge($errors, ['quote-author' => [
            'title' => 'Автор',
            'description' => check_required('quote-author'),
        ]]);
    }
    // @todo валидация тегов

    return $errors;
}

function validate_video($data) {
    // @todo проверка заполненности обязательных полей (Заголовок, Ссылка на видео)
    // @todo валидация ссылки на корректность (встроенная функция filter_var и FILTER_VALIDATE_URL)
    // @todo проверка существования видео на платформе YouTube (check_youtube_url в helpers.php).
    // @todo валидация тегов
}

function validate_photo($data) {
    // @todo проверка заполненности обязательных полей (Заголовок)
    // @todo проверка что поле со ссылкой или поле с картинкой заполнены (одно из)
    // @todo если заполнены оба, то обнулить "Ссылка из интернета" и сохранить картинку с компьютера
    // @todo проверить MIME-тип загруженного файла (png, jpeg, gif) и переместить картинку в папку uploads
    // @todo валидация ссылки на корректность (встроенная функция filter_var и FILTER_VALIDATE_URL)
    // @todo сохранить фото по ссылке (file_get_contents) и добавить в таблицу или ошибка валидации, если не удалось
    // @todo валидация тегов
}

function validate_link($data) {
    // @todo проверка заполненности обязательных полей (Заголовок, ссылка)
    // @todo валидация ссылки на корректность (встроенная функция filter_var и FILTER_VALIDATE_URL)
    // @todo валидация тегов
}

// вспомогательные функции валидации

/**
 * Проверка обязательного поля на заполненность
 * @param string $name   имя проверяемого поля
 *
 * @return string   строка с ошибкой или пустая строка, если ошибки нет
 */
function check_required($name): string {
    if (empty($_POST[$name])) {
        return "Это поле должно быть заполнено";
    }

    return '';
}
