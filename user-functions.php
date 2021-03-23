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
            print("${months} " . get_noun_plural_form($months, 'месяц', 'месяца', 'месяцев') . " назад");
            return;
        case ($days > 7):
            print("${weeks} " . get_noun_plural_form($weeks, 'неделя', 'недели', 'недель') . " назад");
            return;
        case ($days):
            print("${days} " . get_noun_plural_form($days, 'день', 'дня', 'дней') . " назад");
            return;
        case ($hours):
            print("${hours} " . get_noun_plural_form($hours, 'час', 'часа', 'часов') . " назад");
            return;
        case ($minutes):
            print("${minutes} " . get_noun_plural_form($minutes, 'минута', 'минуты', 'минут') . " назад");
            return;
        default:
            print("Недавно");
    }
}
