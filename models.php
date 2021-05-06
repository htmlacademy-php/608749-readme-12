<?php

/**
 * Функция для получения всех типов контента из базы данных
 * @param   mysqli $link   Объект mysqli
 * @return  array|string   ассоциативный массив с данными или сообщение об ошибке
 */
function get_content_types(mysqli $link) {
    $sql_content_types = 'SELECT type, icon FROM content_type';
    $result_content_types = mysqli_query($link, $sql_content_types);

    if (!$result_content_types) {
        return mysqli_error($link);
    }

    return mysqli_fetch_all($result_content_types, MYSQLI_ASSOC);
}

/**
 * Функция для получения популярных постов из базы данных
 * @param   mysqli $link   Объект mysql
 * @return  array|string   ассоциативный массив с данными или сообщение об ошибке
 */
function get_popular_posts(mysqli $link) {
    $sql_popular_posts =
        'SELECT p.id, date, title, content, cite_author, views, login, icon, avatar
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        ORDER BY views DESC
        LIMIT 6';
    $result_popular_posts = mysqli_query($link, $sql_popular_posts);

    if (!$result_popular_posts) {
        return mysqli_error($link);
    }

    return mysqli_fetch_all($result_popular_posts, MYSQLI_ASSOC);
}
