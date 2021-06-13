<li class="comments__item user">
    <div class="comments__avatar">
        <a class="user__avatar-link" href="/user.php?id=<?= $id ?>">
            <img class="comments__picture" src="<?= $avatar; ?>"
                 alt="Аватар пользователя">
        </a>
    </div>
    <div class="comments__info">
        <div class="comments__name-wrapper">
            <a class="comments__user-name" href="/user.php?id=<?= $id ?>">
                <span><?= $login; ?></span>
            </a>
            <time
                class="comments__time"
                datetime="<?= $date; ?>"
                title="<?= date('d.m.Y H:i', strtotime($date)); ?>"
            >
                <?= humanize_date($date); ?>
            </time>
        </div>
        <p class="comments__text">
            <?= $content; ?>
        </p>
    </div>
</li>
