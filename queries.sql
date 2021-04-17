# список типов контента для поста;
INSERT INTO content_type (id, type, icon)
VALUES (1, 'text', 'text'),
       (2, 'quote', 'quote'),
       (3, 'video', 'video'),
       (4, 'photo', 'photo'),
       (5, 'link', 'link');

# список пользователей;
INSERT INTO user (id, registration, email, login, password, avatar)
VALUES (1, NOW(), 'phizntrg@msn.com', 'Владик', 'abc12345', 'userpic.jpg'),
       (2, NOW(), 'wiseb@msn.com', 'Лариса', 'qwwerty', 'userpic-larisa-small.jpg'),
       (3, NOW(), 'yumpy@msn.com', 'Виктор', 'asdfg123', 'userpic-mark.jpg'),
       (4, NOW(), 'sthomas@comcast.net', 'SThomas', 'password', 'https://placekitten.com/640/360'),
       (5, NOW(), 'elflord@yahoo.com', 'ElfLord', '12345zxc', 'https://placekitten.com/640/360'),
       (6, NOW(), 'hahsler@icloud.com', 'HahSler', '098aaa111', 'https://placekitten.com/640/360'),
       (7, NOW(), 'gslondon@gmail.com', 'gsLondon', 'lkjh567', 'https://placekitten.com/640/360'),
       (8, NOW(), 'druschel@outlook.com', 'DrUschel', 'bcye12', 'https://placekitten.com/640/360'),
       (9, NOW(), 'leocharre@att.net', 'LeoCharre', 'foasfa', 'https://placekitten.com/640/360'),
       (10, NOW(), 'mhanoh@me.com', 'Mhanoh', 'asdasgqwetq', 'https://placekitten.com/640/360'),
       (11, NOW(), 'bjornk@outlook.com', 'Bjorn_K', '4124wegaerg', 'https://placekitten.com/640/360'),
       (12, NOW(), 'hillct@icloud.com', 'Hill_Catana', 'q34bli', 'https://placekitten.com/640/360');

# список комментариев к разным постам;
INSERT INTO comment (id, date, content, user_id, post_id)
VALUES (1, NOW(),
        'Гармоническое микророндо представляет собой модальный рок-н-ролл 50-х, о чем подробно говорится в книге М.Друскина "Ганс Эйслер и рабочее музыкальное движение в Германии".',
        5, 1),
       (2, NOW(),
        'Аккорд, как бы это ни казалось парадоксальным, выстраивает нонаккорд, благодаря быстрой смене тембров (каждый инструмент играет минимум звуков).',
        5, 2),
       (3, NOW(),
        'Крещендирующее хождение mezzo forte диссонирует флюгель-горн.',
        5, 3),
       (4, NOW(),
        'Глиссандо, согласно традиционным представлениям, полифигурно варьирует сонорный райдер.',
        5, 4),
       (5, NOW(),
        'Мономерная остинатная педаль образует диссонансный септаккорд. ',
        5, 5),
       (6, NOW(),
        'Развивая эту тему, мономерная остинатная педаль дает open-air, потому что современная музыка не запоминается.',
        5, 6),
       (7, NOW(),
        'Ретро ненаблюдаемо. Легато музыкально. Арпеджио просветляет полиряд.',
        5, 2),
       (8, NOW(),
        'Как отмечает Теодор Адорно, пуанта многопланово заканчивает изоритмический ревер, и здесь в качестве модуса конструктивных элементов используется ряд каких-либо единых длительностей.',
        5, 1);

# список постов;
INSERT INTO post (id, date, title, content, cite_author, views, user_id, content_type_id)
VALUES (1, NOW(), 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Джейсон Стетхем',
        150, 2, 2),
       (2, NOW(), 'Полезный пост про Байкал', 'Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы.
      Байкал считается самым глубоким озером в мире. Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы.
      Байкал считается самым глубоким озером в мире. Озеро Байкал – огромное', '', 28, 2, 1),
       (3, NOW(), 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', '', 3, 1, 1),
       (4, NOW(), 'Наконец, обработал фотки!', 'rock-medium.jpg', '', 1794, 3, 4),
       (5, NOW(), 'Моя мечта', 'coast-medium.jpg', '', 70, 2, 4),
       (6, NOW(), 'Лучшие курсы', 'www.htmlacademy.ru', '', 10500, 1, 5);

# получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента
# @todo объединить с логином пользователя и типом контента
SELECT *
FROM post
ORDER BY views DESC;

# получить список постов для конкретного пользователя;
SELECT *
FROM post
WHERE user_id = 2;

# получить список комментариев для одного поста, в комментариях должен быть логин пользователя;
# @todo объединить с логином пользователя
SELECT *
FROM comment
WHERE post_id = 4;

# добавить лайк к посту;
INSERT INTO post_like (user_id, post_id)
VALUES (2, 6);

# подписаться на пользователя.
INSERT INTO subscription (user_id, recipient_id)
VALUES (2, 1);
