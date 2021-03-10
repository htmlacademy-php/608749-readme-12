<?php

/**
 * Функция, которая возвращает результат: оригинальный текст, если его длина меньше
 * заданного числа символов. В противном случае это урезанный текст с прибавленной к нему ссылкой.
 * @param string $string
 * @param int $max_length
 * @return string
 */
function cut_string(string $string, int $max_length = 300): string {

    if (mb_strlen($string) <= $max_length) return $string;

    $words = explode(' ', $string);
    $result_string = '';

    foreach ($words as $word) {
        if (mb_strlen($result_string . ' ' . $word) > $max_length) break;

        $result_string .= !$result_string ? $word :  ' ' . $word;
    }

    return $result_string . '...';
}
