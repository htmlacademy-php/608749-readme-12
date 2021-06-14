<div class="post-details__user user">
    <div class="post-details__user-info user__info">
        <div class="post-details__avatar user__avatar">
            <a class="post-details__avatar-link user__avatar-link" href="#">
                <img class="post-details__picture user__picture" src="<?= $avatar; ?>"
                     alt="Аватар пользователя">
            </a>
        </div>
        <div class="post-details__name-wrapper user__name-wrapper">
            <a class="post-details__name user__name" href="#">
                <span><?= $login ?></span>
            </a>
            <time class="post-details__time user__time" datetime="<?= date('d.m.Y H:i', strtotime($registration)); ?>">
                <?= humanize_date($registration, false) ?> на сайте
            </time>
        </div>
    </div>
    <div class="post-details__rating user__rating">
        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
            <span class="post-details__rating-amount user__rating-amount"><?= $subscribers; ?></span>
            <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form($subscribers, 'подписчик', 'подписчика', 'подписчиков') ?></span>
        </p>
        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
            <span class="post-details__rating-amount user__rating-amount"><?= $posts ?></span>
            <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form($posts, 'публикация', 'публикации', 'публикаций') ?></span>
        </p>
    </div>
    <div class="post-details__user-buttons user__buttons">
        <button class="user__button user__button--subscription button button--main" type="button">
            Подписаться
        </button>
        <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
    </div>
</div>
