<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= $post['title'] ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <div class="post-details__wrapper post-<?= $post['icon']; ?>">
                <div class="post-details__main-block post post--details">
                    <?= create_post_template($post); ?>
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                <svg class="post__indicator-icon" width="20" height="17">
                                    <use xlink:href="#icon-heart"></use>
                                </svg>
                                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                                     height="17">
                                    <use xlink:href="#icon-heart-active"></use>
                                </svg>
                                <span><?= $post['likes'] ?: 0 ?></span>
                                <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span><?= count($comments) ?></span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-repost"></use>
                                </svg>
                                <span>5</span>
                                <span class="visually-hidden">количество репостов</span>
                            </a>
                        </div>
                        <span class="post__view">
                            <?= $post['views'] ?>
                            <?= get_noun_plural_form($post['views'], 'просмотр', 'просмотра', 'просмотров'); ?></span>
                    </div>
                    <ul class="post__tags">
                        <?php foreach ($hashtags as $hashtag): ?>
                        <li><a href="#">#<?= $hashtag['hashtag'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="comments">
                        <form class="comments__form form" action="#" method="post">
                            <div class="comments__my-avatar">
                                <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                            </div>
                            <div class="form__input-section form__input-section--error">
                                <textarea class="comments__textarea form__textarea form__input"
                                          placeholder="Ваш комментарий"></textarea>
                                <label class="visually-hidden">Ваш комментарий</label>
                                <button class="form__error-button button" type="button">!</button>
                                <div class="form__error-text">
                                    <h3 class="form__error-title">Ошибка валидации</h3>
                                    <p class="form__error-desc">Это поле обязательно к заполнению</p>
                                </div>
                            </div>
                            <button class="comments__submit button button--green" type="submit">Отправить</button>
                        </form>
                        <div class="comments__list-wrapper">
                            <ul class="comments__list">
                                <?php foreach ($comments as $comment): ?>
                                    <?= include_template('post-details/comment.php', $comment); ?>
                                <?php endforeach; ?>
                            </ul>
                            <a class="comments__more-link" href="#">
                                <span>Показать все комментарии</span>
                                <sup class="comments__amount"><?= count($comments); ?></sup>
                            </a>
                        </div>
                    </div>
                </div>
                <?= include_template('post-details/user.php', [
                    'login' => $user['login'],
                    'avatar' => $user['avatar'],
                    'registration' => $user['registration'],
                    'posts' => $user_posts,
                    'subscribers' => $user_subscribers,
                ]); ?>
            </div>
        </section>
    </div>
</main>

