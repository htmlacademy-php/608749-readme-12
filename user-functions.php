<?php

// Устанавливаем временную зону по умолчанию
date_default_timezone_set('Europe/Amsterdam');

/**
 * Функция, которая возвращает результат: оригинальный текст, если его длина меньше
 * заданного числа символов. В противном случае это урезанный текст с прибавленным к нему троеточием.
 * @param string $string
 * @param int $max_length
 * @return string
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
 * @param string $content
 * @param string $link
 * @param int $max_length
 * @return string
 */
function create_text_post(string $content, string $link = '#', int $max_length = 300): string {

    $result = '<p>' . cut_string($content, $max_length) . '</p>';

    if (mb_strlen($content) > $max_length) {
        $result .= '<a class="post-text__more-link" href="' . $link . '">Читать далее</a>';
    };

    return $result;
}

/**
 * Функция, которая форматирует дату в относительный ("человеческий") формат в виде прошедших с данного моменты
 * минут, часов, дней, недель или месяцев.
 * @param string $date
 */
function humanize_date(string $date) {

    $current = strtotime('now');
    $post_date = strtotime($date);
    $diff = $current - $post_date;

    switch ($diff) {
        case ($diff < 3600):
            $time = ceil($diff / 60);
            print("${time} минуты назад");
            break;
        case ($diff >= 3600 and $diff < 86400):
            $time = ceil($diff / 3600);
            print("${time} часов назад");
            break;
        case ($diff >= 86400 and $diff < 604800):
            $time = ceil($diff / 86400);
            print("${time} дней назад");
            break;
        case ($diff >= 604800 and $diff < 3024000):
            $time = ceil($diff / 604800);
            print("${time} недель назад");
            break;
        case ($diff > 3024000):
            $time = ceil($diff / 3024000);
            print("${time} месяцев назад");
            break;
    }
}
