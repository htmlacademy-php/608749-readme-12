<?php

/**
 * Абстрактная функция для составления запросов с подготовленными
 * выражениями.
 * @param mysqli $link          Объект mysqli
 * @param string $sql           Подготовленное выражение
 * @param array $sql_params     (опционально) Массив с параметрами для подготовленного выражения
 *
 * @return array|string         Возвращает массив с данными или строку с ошибкой
 */
function get_data(
    mysqli $link,
    string $sql,
    array $sql_params = []
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
 * Адаптер для подготовки данных формы к отправке в базу данных
 *
 * @param string $active_type   тип поста
 * @param array $data           данные от пользователя
 * @param array $photo          загруженное фото
 *
 * @return array                массив с полями для отправки
 */
function get_request_content(string $active_type, array $data, array $photo): array {
    switch ($active_type) {
        case 'quote':
            return [
                'content' => $data['cite-text'],
                'cite_author' => $data['quote-author'],
            ];
        case 'video':
            return [
                'content' => $data['video-heading'],
            ];
        case 'photo':
            return empty($photo) ? [
                'content' => save_photo_from_url($data['photo-heading'])
            ] : [
                'content' => save_photo($photo['userpic-file-photo'])
            ];
        case 'link':
            return [
                'content' => $data['post-link'],
            ];
        case 'text':
        default:
            return [
                'content' => $data['post-text'],
            ];
    }
}

/**
 * Функция для получения всех типов контента из базы данных
 * @param   mysqli $link   Объект mysqli
 *
 * @return  array|string   ассоциативный массив с данными или сообщение об ошибке
 */
function get_content_types(mysqli $link) {
    $sql = 'SELECT * FROM content_type';

    return get_data($link, $sql);
}

/**
 * Функция для получения id типа контента у поста
 * @param   mysqli $link   Объект mysqli
 * @param   string $type   Тип контента
 *
 * @return  array|string   ассоциативный массив с данными или сообщение об ошибке
 */
function get_post_content_type(mysqli $link, string $type) {
    $sql = 'SELECT id FROM content_type
            WHERE icon = ?';

    return get_data($link, $sql, [ $type ]);
}

/**
 * Функция для получения популярных постов из базы данных
 * @param   mysqli $link        Объект mysql
 * @param   array $params       ассоциативный массив с параметрами поиска:
 *                              - filter      активный фильтр
 *                              - sort        тип сортировки
 *                              - direction   направление сортировки
 * @param   int $limit          лимит получаемых постов
 *
 * @return  array|string  ассоциативный массив с данными или сообщение об ошибке
 */
function get_popular_posts(
    mysqli $link,
    array $params,
    int $limit
) {
    $sort_param = $params['sort'];
    $direction = strtoupper($params['direction']);
    $sort = " ORDER BY $sort_param $direction";
    $sql =
        'SELECT p.id, date, title, content, cite_author, views, login, icon, avatar, pl.likes, c.comments
        FROM post p
        JOIN user u ON p.user_id = u.id
        JOIN content_type ct ON p.content_type_id = ct.id
        LEFT OUTER JOIN (
            SELECT post_id, COUNT(user_id) AS likes FROM post_like
            GROUP BY post_id
        ) pl ON p.id = pl.post_id
        LEFT OUTER JOIN (
            SELECT post_id, COUNT(id) AS comments FROM comment c
            GROUP BY post_id
        ) c ON p.id = c.post_id
        WHERE ? > 0 AND content_type_id = ?
           OR
              ? = 0 AND content_type_id > 0 ' . $sort . ' LIMIT ' .$limit;

    return get_data($link, $sql, [
        $params['filter'],
        $params['filter'],
        $params['filter']
    ]);
}

/**
 * Функция для получения общего количества постов из базы данных
 * (включая отфильтрованные посты)
 * @param mysqli $link     Объект mysql
 * @param string $filter   Активный фильтр
 *
 * @return array|string
 */
function get_total_posts(mysqli $link, string $filter) {
    $sql = 'SELECT COUNT(id) AS total FROM post
            WHERE ? > 0 AND content_type_id = ?
               OR
                  ? = 0 AND content_type_id > 0';

    return get_data($link, $sql, [ $filter, $filter, $filter ]);
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
    SELECT COUNT(pl.user_id) AS likes
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
        'SELECT COUNT(id) AS posts
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

/**
 * Функция для отправки данных нового поста в базу данных
 *
 * @param mysqli $link          Объект mysql
 * @param string $active_type   Тип поста
 * @param array $data           Данные для отправки
 * @param array $photos         Данные фотографии
 *
 * @return int|string          id поста или ошибка
 */
function set_post (mysqli $link, string $active_type, array $data, array $photos) {
    $content = get_request_content($active_type, $data, $photos);
    $content_type_id = get_post_content_type($link, $active_type)[0];

    $request_data = [
        'title' => $data['text-heading'],
        'content' => $content['content'],
        'cite_author' => $content['cite_author'] ?? '',
        'views' => 0,
        'user_id' => 1,
        'content_type_id' => $content_type_id['id'],
    ];

    $query = '';

    foreach ($request_data as $key => $item) {
        $query .= !$query ? "$key = ?" :  ", " . "$key = ?";
    }

    $sql = "INSERT INTO post SET $query;";

    $stmt = db_get_prepare_stmt($link, $sql, $request_data);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_get_result($stmt);

    return mysqli_insert_id($link);
}

/**
 * Функция для отправки нового тэга в базу данных
 *
 * @param mysqli $link          Объект mysql
 * @param int $post_id          id поста
 * @param string $tag           Хэштег, который нужно добавить
 */
function set_post_tag (mysqli $link, int $post_id, string $tag) {

    $hashtag_id = get_hashtag_id($link, $tag);

    $sql = "INSERT INTO post_hashtag SET post_id = ?, hashtag_id = ?";

    $stmt = db_get_prepare_stmt($link, $sql, [ $post_id, $hashtag_id ]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_get_result($stmt);
}

/**
 * Функция для получения id нужного хэштега путем получения его из БД или добавления
 * нового, в случае, если такого хэштега еще нет
 *
 * @param mysqli $link          Объект mysql
 * @param string $hashtag       Хэштег, который нужно добавить
 */
function get_hashtag_id(mysqli $link, string $hashtag) {
    $sql = "SELECT id FROM hashtag h
            WHERE h.hashtag = ?";

    $id = get_data($link, $sql, [ $hashtag ]);

    if (!empty($id)) {
        return $id[0]['id'];
    }

    $sql = "INSERT INTO hashtag SET hashtag = ?";

    $stmt = db_get_prepare_stmt($link, $sql, [ $hashtag ]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_get_result($stmt);

    return mysqli_insert_id($link);
}
