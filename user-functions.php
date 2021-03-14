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
 * Функция, которая проверяет текст: если его длина больше заданного числа, она возвращает ссылку
 * для перехода на полную версию текста.
 * @param string $content
 * @param int $max_length
 * @return string
 */
function add_link(string $content, int $max_length = 300): string {
    if (mb_strlen($content) < $max_length) {
        return '';
    }

    return '<a class="post-text__more-link" href="#">Читать далее</a>';
}
