<?php

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
