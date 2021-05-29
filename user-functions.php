<?php

// Устанавливаем временную зону по умолчанию
date_default_timezone_set('Europe/Amsterdam');

/**
 * Функция для инициализации базы данных в приложении
 * @param   array $db       Массив с настройками для базы данных
 *
 * @return  mysqli|string   Объект mysqli для запросов в базу данных или строка с ошибкой
 */
function init(array $db) {
    $link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

    if (!$link) {
        return mysqli_connect_error();
    }

    mysqli_set_charset($link, 'utf8');

    return $link;
}

/**
 * Вспомогательная функция для проверки полученных данных на наличие ошибок
 * @param   mixed ...$params  параметры, которые нужно проверить на наличие ошибки
 *
 * @return  string            строка с ошибкой или пустая строка, если ошибок нет
 */
function catch_mysql_error(...$params): string {
    foreach ($params as $param) {
        if (gettype($param) === 'string') {
            return $param;
        }
    }

    return '';
}

/**
 * Функция, которая возвращает результат: оригинальный текст, если его длина меньше
 * заданного числа символов. В противном случае это урезанный текст с прибавленным к нему троеточием.
 * @param string $string    строка, которую требуется обрезать
 * @param int $max_length   максимально допустимый размер строки
 *
 * @return string           обрезанная строка
 */
function cut_string(string $string, int $max_length = 300): string {

    if (mb_strlen($string) <= $max_length) {
        return $string;
    }

    $words = explode(' ', $string);
    $result_string = '';

    foreach ($words as $word) {
        if (mb_strlen($result_string . ' ' . $word) > $max_length) {
            break;
        }

        $result_string .= !$result_string ? $word :  ' ' . $word;
    }

    return $result_string . '...';
}

/**
 * Функция, которая генерирует разметку текстового поста. И, в зависимости от его длины,
 * обрезает текст и добавляет к нему ссылку на полный пост.
 * @param string $content   контент, который вставляется в разметку
 * @param string $link      ссылка на полную версию поста
 * @param int $max_length   максимально допустимый размер текста
 *
 * @return string           сгенерированная разметка для шаблона
 */
function create_text_post(string $content, string $link = '#', int $max_length = 300): string {

    $result = '<p>' . cut_string($content, $max_length) . '</p>';

    if (mb_strlen($content) > $max_length) {
        $result .= '<a class="post-text__more-link" href="' . $link . '">Читать далее</a>';
    };

    return $result;
}

/**
 * Функция, которая форматирует дату в относительный ("человеческий") формат в виде прошедших с данного момента
 * минут, часов, дней, недель или месяцев.
 * @param string $date      дата, которую нужно отформатировать
 * @param bool $is_full     полный или не полный вариант фразы
 *
 * @return string         дата в "человеческом" формате в виде строки
 */
function humanize_date(string $date, bool $is_full = true): string {

    $current = date_create();
    $post_date = date_create($date);
    $diff = date_diff($post_date, $current);

    $minutes = ceil($diff->i);
    $hours = ceil($diff->h);
    $days = ceil($diff->d);
    $weeks = ceil($days / 7);
    $months = ceil($diff->m);

    switch (true) {
        case ($months):
            return "$months " . get_noun_plural_form($months, 'месяц', 'месяца', 'месяцев') . ($is_full ? ' назад' : '');
        case ($days >= 7):
            return "$weeks " . get_noun_plural_form($weeks, 'неделя', 'недели', 'недель') . ($is_full ? ' назад' : '');
        case ($days):
            return "$days " . get_noun_plural_form($days, 'день', 'дня', 'дней') . ($is_full ? ' назад' : '');
        case ($hours):
            return "$hours " . get_noun_plural_form($hours, 'час', 'часа', 'часов') . ($is_full ? ' назад' : '');
        case ($minutes):
            return "$minutes " . get_noun_plural_form($minutes, 'минута', 'минуты', 'минут') . ($is_full ? ' назад' : '');
        default:
            return 'недавно';
    }
}
