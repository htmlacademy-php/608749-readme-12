<?php

require_once 'user-functions.php';
require_once 'helpers.php';

$is_auth = rand(0, 1);

$user_name = 'Тина Кузьменко';

$title = 'readme: популярное';

$posts = [
  [
      'heading' => 'Цитата',
      'type' => 'post-quote',
      'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
      'username' => 'Лариса',
      'avatar' => 'userpic-larisa-small.jpg'
  ],
  [
      'heading' => 'Полезный пост про Байкал',
      'type' => 'post-text',
      'content' => 'Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы.
      Байкал считается самым глубоким озером в мире. Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы.
      Байкал считается самым глубоким озером в мире. Озеро Байкал – огромное',
      'username' => 'Лариса',
      'avatar' => 'userpic-larisa-small.jpg'
  ],
  [
      'heading' => 'Игра престолов',
      'type' => 'post-text',
      'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
      'username' => 'Владик',
      'avatar' => 'userpic.jpg'
  ],
  [
      'heading' => 'Наконец, обработал фотки!',
      'type' => 'post-photo',
      'content' => 'rock-medium.jpg',
      'username' => 'Виктор',
      'avatar' => 'userpic-mark.jpg'
  ],
  [
      'heading' => 'Моя мечта',
      'type' => 'post-photo',
      'content' => 'coast-medium.jpg',
      'username' => 'Лариса',
      'avatar' => 'userpic-larisa-small.jpg'
  ],
  [
      'heading' => 'Лучшие курсы',
      'type' => 'post-link',
      'content' => 'www.htmlacademy.ru',
      'username' => 'Владик',
      'avatar' => 'userpic.jpg'
  ],
];

$main = include_template('main.php', [
    'posts' => $posts,
]);

$layout = include_template('layout.php', [
    'main' => $main,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout);
