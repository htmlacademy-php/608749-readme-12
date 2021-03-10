<?php

/**
 * Функция, которая возвращает результат: оригинальный текст, если его длина меньше
 * заданного числа символов. В противном случае это урезанный текст с прибавленной к нему ссылкой.
 * @param $string
 * @param int $symbols
 */
function cut_string($string, $symbols = 300) {

    if (mb_strlen($string) <= $symbols) return $string;

    $words = explode(' ', $string);
    $result_string = '';

    foreach ($words as $word) {
        if (mb_strlen($result_string . ' ' . $word) > $symbols) break;

        if (!$result_string) $result_string .= $word;

        $result_string .= ' ' . $word;
    }

    return $result_string . '...';
}
