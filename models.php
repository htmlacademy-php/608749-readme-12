<?php

/**
 * Функция для получения всех типов контента из базы данных
 * @param   mysqli $link   Объект mysqli
 *
 * @return  array|string   ассоциативный массив с данными или сообщение об ошибке
 */
function get_content_types(mysqli $link) {
    $sql_content_types = 'SELECT * FROM content_type';
    $result_content_types = mysqli_query($link, $sql_content_types);

    if (!$result_content_types) {
        return mysqli_error($link);
    }

    return mysqli_fetch_all($result_content_types, MYSQLI_ASSOC);
}

/**
 * Функция для получения популярных постов из базы данных
 * @param   mysqli $link                Объект mysql
 * @param   int|string $active_filter  id активного фильтра
 *
 * @return  array|string  ассоциативный массив с данными или сообщение об ошибке
 */
function get_popular_posts(
    mysqli $link,
    $active_filter
) {

    $sql_popular_posts =
        'SELECT p.id, date, title, content, cite_author, cover, views, login, icon, avatar
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        WHERE ? > 0 AND content_type_id = ?
           OR
              ? = 0 AND content_type_id > 0
        ORDER BY views DESC
        LIMIT 6';

    $stmt = db_get_prepare_stmt($link, $sql_popular_posts, [$active_filter, $active_filter, $active_filter]);
    mysqli_stmt_execute($stmt);

    $result_popular_posts = mysqli_stmt_get_result($stmt);

    if (!$result_popular_posts) {
        return mysqli_error($link);
    }

    return mysqli_fetch_all($result_popular_posts, MYSQLI_ASSOC);
}

/**
 * Функция для получения деталей поста из базы данных
 * @param mysqli $link
 * @param int $post_id
 * @return array|string
 * @throws Exception
 */
function get_post_details (
    mysqli $link,
    int $post_id
) {
    $sql_post =
        'SELECT p.id, date, title, content, cite_author, views, user_id, icon
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        WHERE p.id = ?';

    $stmt = db_get_prepare_stmt($link, $sql_post, [$post_id]);
    mysqli_stmt_execute($stmt);

    $result_post = mysqli_stmt_get_result($stmt);

    if (!$result_post) {
        return mysqli_error($link);
    }

    return mysqli_fetch_all($result_post, MYSQLI_ASSOC);
}
