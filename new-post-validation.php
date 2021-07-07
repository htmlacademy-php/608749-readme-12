<?php

/**
 * Проверка обязательного поля на заполненность
 * @param string $field_title   Заголовок поля
 * @param string $field_name    Имя проверяемого поля
 *
 * @return array   Ассоциативный массив с описанием ошибки
 */
function check_required(string $field_title, string $field_name): array {
    if (empty($_POST[$field_name])) {
        return [
            'title' => $field_title,
            'description' => "Это поле должно быть заполнено",
        ];
    }

    return [];
}

/**
 * Проверка заполненности хотя бы одного поля для фото
 *
 * @return array   Ассоциативный массив с описанием ошибки
 */
function check_photo_fields(): array {
    if (empty($_POST['photo-heading']) && empty($_POST['userpic-file-photo'])) {
        return [
            'title' => 'Отсутствует фото',
            'description' => "Пожалуйста, добавьте ссылку из интернета или загрузите файл",
        ];
    }

    return [];
}

/**
 * Функция валидации поля с тегами
 * @return array  ассоциативный массив с ошибками
 */
function check_tags(): array {
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
    $required = check_required('Заголовок', 'text-heading');

    if (!empty($required)) {
        $errors = array_merge($errors, [ 'text-heading' => $required ]);
    }

    if (!empty(check_tags())) {
        $errors = array_merge($errors, [ 'post-tags' => check_tags()]);
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

    if (!empty(check_required('Текст поста', 'post-text'))) {
        $errors[] = ['post-text' => check_required('Текст поста', 'post-text') ];
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

    if (!empty(check_required('Текст цитаты', 'cite-text'))) {
        $errors[] = ['cite-text' => check_required('Текст цитаты', 'cite-text') ];
    }

    if (!empty(check_required('Автор', 'quote-author'))) {
        $errors[] = ['quote-author' => check_required('Автор', 'quote-author') ];
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

    if (!empty(check_required('Ссылка YouTube', 'video-heading'))) {
        $errors[] = [ 'video-heading' => check_required('Ссылка YouTube', 'video-heading') ];
    }

    if (validate_url('video-heading')) {
        $errors[] = [ 'video-heading' => validate_url('video-heading') ];
    }

    if (validate_youtube('video-heading')) {
        $errors[] = [ 'video-heading' => validate_youtube('video-heading') ];
    }

    return $errors;
}

/**
 * Функция валидации полей формы с картинкой
 * @return array   ассоциативный массив с ошибками
 */
function validate_photo_post(): array {
    $errors = [];

    if (!empty(validate_common_fields())) {
        $errors[] = validate_common_fields();
    }

    if (!empty(check_photo_fields())) {
        $errors[] = [ 'photo-heading' => check_photo_fields() ];
    }

    if (validate_url('photo-heading')) {
        $errors[] = [ 'photo-heading' => validate_url('photo-heading') ];
    }

    // @todo если заполнены оба, то обнулить "Ссылка из интернета" и сохранить картинку с компьютера
    // @todo проверить MIME-тип загруженного файла (png, jpeg, gif) и переместить картинку в папку uploads
    // @todo сохранить фото по ссылке (file_get_contents) и добавить в таблицу или ошибка валидации, если не удалось

    return $errors;
}

/**
 * Функция валидации полей формы со ссылкой
 * @return array   ассоциативный массив с ошибками
 */
function validate_link_post() {
    $errors = [];

    if (!empty(validate_common_fields())) {
        $errors[] = validate_common_fields();
    }

    if (!empty(check_required('Ссылка', 'post-link'))) {
        $errors[] = [ 'post-link' => check_required('Ссылка', 'post-link') ];
    }

    if (validate_url('post-link')) {
        $errors[] = [ 'post-link' => validate_url('post-link') ];
    }

    return $errors;
}

/**
 * Функция для проверки наличия ошибок у поля и отрисовки блока с ошибками,
 * если они есть
 * @param array $field_errors     массив с ошибками
 *
 * @return string      разметка показа ошибки
 */
function show_field_errors(array $field_errors): string {
    $errors = '';

    if (empty($field_errors)) {
        return $errors;
    }

    foreach ($field_errors as $error) {
        $errors = $errors . '<h3 class="form__error-title">' . $error['title'] . '</h3>
                <p class="form__error-desc">' . $error['description'] . '</p>';
    }

    return '<button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">' . $errors . '</div>';
}
