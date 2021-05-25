<?php

/**
 * Абстрактная функция для составления запросов с подготовленными
 * выражениями.
 * @param mysqli $link          Объект mysqli
 * @param string $sql           Подготовленное выражение
 * @param array $sql_params     Массив с параметрами для подготовленного выражения
 *
 * @return array|string         Возвращает массив с данными или строку с ошибкой
 */
function get_data(
    mysqli $link,
    string $sql,
    array $sql_params
) {
    $stmt = db_get_prepare_stmt($link, $sql, $sql_params);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return mysqli_error($link);
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Функция для получения всех типов контента из базы данных
 * @param   mysqli $link   Объект mysqli
 *
 * @return  array|string   ассоциативный массив с данными или сообщение об ошибке
 */
function get_content_types(mysqli $link) {
    $sql = 'SELECT * FROM content_type';

    return get_data($link, $sql, []);
}

/**
 * Функция для получения популярных постов из базы данных
 * @param   mysqli $link                Объект mysql
 * @param   int|string $active_filter   id активного фильтра
 *
 * @return  array|string  ассоциативный массив с данными или сообщение об ошибке
 */
function get_popular_posts(
    mysqli $link,
    $active_filter
) {

    $sql =
        'SELECT p.id, date, title, content, cite_author, cover, views, login, icon, avatar
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        WHERE ? > 0 AND content_type_id = ?
           OR
              ? = 0 AND content_type_id > 0
        ORDER BY views DESC
        LIMIT 6';

    return get_data($link, $sql, [$active_filter, $active_filter, $active_filter]);
}

/**
 * Функция для получения количества лайков к посту
 * @param mysqli $link      Объект mysql
 * @param int $post_id      id поста
 *
 * @return array|string
 */
function get_likes(
    mysqli $link,
    int $post_id
) {
    $sql = '
    SELECT COUNT(l.user_id) likes
    FROM post_like l
    JOIN post p ON l.post_id = p.id
    WHERE p.id = ?';

    return get_data($link, $sql, [$post_id]);
}

/**
 * Функция для получения деталей поста из базы данных
 * @param mysqli $link      Объект mysql
 * @param int $post_id      id поста
 *
 * @return array|string
 */
function get_post_details (
    mysqli $link,
    int $post_id
) {
    $sql =
        'SELECT p.id, date, title, content, cite_author, views, p.user_id, icon
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        WHERE p.id = ?';

    return get_data($link, $sql, [$post_id]);
}

/**
 * Функция для получения комментариев поста из базы данных
 * @param mysqli $link      Объект mysql
 * @param int $post_id      id поста
 *
 * @return array|string
 */
function get_post_comments (
    mysqli $link,
    int $post_id
) {
    $sql =
        'SELECT c.id, c.date, c.content, c.user_id, login, avatar
        FROM comment c
        JOIN user u ON c.user_id = u.id
        JOIN post p ON c.post_id = p.id
        WHERE post_id = ?';

    return get_data($link, $sql, [$post_id]);
}
