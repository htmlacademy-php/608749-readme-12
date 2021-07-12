<?php

/**
 * Проверка обязательного поля на заполненность
 * @param string $field_title   Заголовок поля
 * @param string $field_name    Имя проверяемого поля
 *
 * @return array   Ассоциативный массив с описанием ошибки
 */
function validate_required(string $field_title, string $field_name): array {
    if (empty($_POST[$field_name])) {
        return [
            'title' => $field_title,
            'description' => "Это поле должно быть заполнено",
        ];
    }

    return [];
}

/**
 * Проверка валидности загружаемого файла
 *
 * @return array
 */
function validate_photo_format(): array {
    $file_type = $_FILES['userpic-file-photo']['type'];
    $valid_formats = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

    if (in_array($file_type, $valid_formats)) {
        return [
            'title' => 'Фото',
            'description' => 'Неверный формат загружаемого файла. Допустимые форматы: ' . implode(' , ', $valid_formats)
        ];
    }

    return [];
}

/**
 * Функция валидации поля с тегами
 * @return array  ассоциативный массив с ошибками
 */
function validate_tags(): array {
    $field_title = 'Теги';
    $field_name = 'post-tags';
    $errors = [];

    if (empty($_POST[$field_name])) {
        return $errors;
    }

    $tags = explode(' ', $_POST[$field_name]);

    foreach ($tags as $tag) {
        if (substr($tag, 0, 1) !== '#') {
            $errors = array_merge($errors, [
                'title' => $field_title,
                'description' => 'Каждый тег должен начинаться со знака решетки'
            ]);
        }

        if (strrpos($tag, '#') > 0) {
            $errors = array_merge($errors, [
                'title' => $field_title,
                'description' => 'Теги должны разделяться пробелами'
            ]);
        }

        if (strlen($tag) < 2) {
            $errors = array_merge($errors, [
                'title' => $field_title,
                'description' => 'Тег не может состоять из одного символа'
            ]);
        }
    }

    return $errors;
}

/**
 * Функция валидации ссылки на корректность
 * @param string $field_name
 * @return array    ассоциативный массив с ошибками
 */
function validate_url(string $field_name): array {
    $error = [];

    if (array_key_exists($field_name, $_POST) && !filter_var($_POST[$field_name], FILTER_VALIDATE_URL)) {
        $error = [
            'title' => 'Ссылка',
            'description' => 'Значение поля должно быть корректным URL-адресом'
        ];
    }

    return $error;
}

/**
 * Функция валидации ссылки на корректность
 * @param string $field_name
 * @return array    ассоциативный массив с ошибками
 */
function validate_youtube(string $field_name): array {
    $error = [];

    if (array_key_exists($field_name, $_POST) && check_youtube_url($_POST[$field_name])) {
        $error = [
            'title' => 'Видео',
            'description' => check_youtube_url($_POST[$field_name])
        ];
    }

    return $error;
}

/**
 * Функция валидации общих полей формы
 * @return array  ассоциативный массив с ошибками
 */
function validate_common_fields(): array {
    $errors = [];
    $required = validate_required('Заголовок', 'text-heading');

    if (!empty($required)) {
        $errors = array_merge($errors, [ 'text-heading' => $required ]);
    }

    if (!empty(validate_tags())) {
        $errors = array_merge($errors, [ 'post-tags' => validate_tags()]);
    }

    return $errors;
}

/**
 * Функция валидации полей формы с текстовым постом
 * @return array   ассоциативный массив с ошибками
 */
function validate_text_post(): array {
    $errors = [];

    if (!empty(validate_common_fields())) {
        $errors[] = validate_common_fields();
    }

    if (!empty(validate_required('Текст поста', 'post-text'))) {
        $errors[] = ['post-text' => validate_required('Текст поста', 'post-text') ];
    }

    return $errors;
}

/**
 * Функция валидации полей формы с цитатой
 * @return array   ассоциативный массив с ошибками
 */
function validate_quote_post(): array {
    $errors = [];

    if (!empty(validate_common_fields())) {
        $errors[] = validate_common_fields();
    }

    if (!empty(validate_required('Текст цитаты', 'cite-text'))) {
        $errors[] = ['cite-text' => validate_required('Текст цитаты', 'cite-text') ];
    }

    if (!empty(validate_required('Автор', 'quote-author'))) {
        $errors[] = ['quote-author' => validate_required('Автор', 'quote-author') ];
    }

    return $errors;
}

/**
 * Функция валидации полей формы с видео
 * @return array   ассоциативный массив с ошибками
 */
function validate_video_post(): array {
    $errors = [];

    if (!empty(validate_common_fields())) {
        $errors[] = validate_common_fields();
    }

    if (!empty(validate_required('Ссылка YouTube', 'video-heading'))) {
        $errors[] = [ 'video-heading' => validate_required('Ссылка YouTube', 'video-heading') ];
    }

    if (validate_url('video-heading')) {
        $errors[] = [ 'video-heading' => validate_url('video-heading') ];
    } else {
        if (validate_youtube('video-heading')) {
            $errors[] = [ 'video-heading' => validate_youtube('video-heading') ];
        }
    }

    return $errors;
}

/**
 * Функция валидации полей формы с картинкой
 * @return array   ассоциативный массив с ошибками
 */
function validate_photo_post(): array {
    $errors = [];

    $file_filled = isset($_FILES['userpic-file-photo']) && $_FILES['userpic-file-photo']['error'] === 0;
    $url_filled = isset($_POST['photo-heading']);

    if (!empty(validate_common_fields())) {
        $errors[] = validate_common_fields();
    }

    // @todo разобраться с проверкой (пока не работает)
    if (!$url_filled && !$file_filled) {
        $errors[] = [ 'photo-heading' => [
            'title' => 'Отсутствует фото',
            'description' => "Пожалуйста, добавьте ссылку из интернета или загрузите файл",
        ]];
    }

    if ($url_filled && !$file_filled) {
        if (validate_url('photo-heading')) {
            $errors[] = [ 'photo-heading' => validate_url('photo-heading') ];
        }
    }

    // @todo разобраться с проверкой
    if ($file_filled) {
        if (!empty(validate_photo_format())) {
            $errors[] = [ 'userpic-file-photo' => validate_photo_format() ];
        }
    }

    return $errors;
}

/**
 * Функция валидации полей формы со ссылкой
 * @return array   ассоциативный массив с ошибками
 */
function validate_link_post(): array {
    $errors = [];

    if (!empty(validate_common_fields())) {
        $errors[] = validate_common_fields();
    }

    if (!empty(validate_required('Ссылка', 'post-link'))) {
        $errors[] = [ 'post-link' => validate_required('Ссылка', 'post-link') ];
    }

    if (validate_url('post-link')) {
        $errors[] = [ 'post-link' => validate_url('post-link') ];
    }

    return $errors;
}
