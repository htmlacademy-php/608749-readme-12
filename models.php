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
 * @param   mysqli $link        Объект mysql
 * @param   array $params       ассоциативный массив с параметрами поиска:
 *                              - filter      активный фильтр
 *                              - sort        тип сортировки
 *                              - direction   направление сортировки
 *
 * @return  array|string  ассоциативный массив с данными или сообщение об ошибке
 */
function get_popular_posts(
    mysqli $link,
    array $params
) {
    $sort_param = $params['sort'];
    $direction = strtoupper($params['direction']);
    $sort = $sort_param === 'likes' ? " ORDER BY likes $direction" : " ORDER BY $sort_param $direction";
    $sql =
        'SELECT p.id, date, title, content, cite_author, cover, views, login, icon, avatar, pl.likes
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        LEFT OUTER JOIN (
            SELECT post_id, COUNT(user_id) AS likes FROM post_like
            GROUP BY post_id
        ) pl ON p.id = pl.post_id
        WHERE ? > 0 AND content_type_id = ?
           OR
              ? = 0 AND content_type_id > 0 ' . $sort . ' LIMIT 6';

    return get_data($link, $sql, [
        $params['filter'],
        $params['filter'],
        $params['filter']
    ]);
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
    SELECT COUNT(pl.user_id) likes
    FROM post_like pl
    JOIN post p ON pl.post_id = p.id
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
 * Функция для получения информации о пользователе из базы данных
 * @param mysqli $link
 * @param int $user_id
 *
 * @return array|string
 */
function get_user(
    mysqli $link,
    int $user_id
) {
    $sql =
        'SELECT registration, avatar, login
        FROM user
        WHERE id = ?';

    return get_data($link, $sql, [$user_id]);
}

/**
 * Функция для получения информации о количестве подписчиков у пользователя
 * @param mysqli $link
 * @param int $user_id
 *
 * @return array|string
 */
function get_subscribers_amount(
    mysqli $link,
    int $user_id
) {
    $sql =
        'SELECT COUNT(recipient_id) subscribers
        FROM subscription
        WHERE recipient_id = ?';

    return get_data($link, $sql, [$user_id]);
}

/**
 * Функция для получения информации о количестве постов у пользователя
 * @param mysqli $link
 * @param int $user_id
 *
 * @return array|string
 */
function get_posts_amount (
    mysqli $link,
    int $user_id
) {
    $sql =
        'SELECT COUNT(id) posts
        FROM post
        WHERE user_id = ?';

    return get_data($link, $sql, [$user_id]);
}

/**
 * Функция для получения хэштегов к посту
 * @param mysqli $link
 * @param int $post_id
 *
 * @return array|string
 */
function get_post_hashtags(
    mysqli $link,
    int $post_id
) {
    $sql =
        'SELECT p.post_id, p.hashtag_id, hashtag
        FROM post_hashtag p
        JOIN hashtag h on p.hashtag_id = h.id
        WHERE post_id = ?';

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
