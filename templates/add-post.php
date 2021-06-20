<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php foreach ($content_types as $content_type):
                            $id = $content_type['id'];
                            $label = $content_type['type'];
                            $type = $content_type['icon'];
                        ?>
                            <li class="adding-post__tabs-item filters__item">
                                <a class="adding-post__tabs-link filters__button filters__button--<?= $type; ?>
                                <?= $active_type === $type ? 'filters__button--active tabs__item--active' : '' ?> tabs__item button"
                                   href="/new-post.php?type=<?= $type; ?>">
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-<?= $type; ?>"></use>
                                    </svg>
                                    <span><?= $label ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="adding-post__tab-content">
                    <?= include_template('add-post/form-layout.php', [
                        'form_title' => $form_title,
                        'active_type' => $active_type ?: 'text',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</main>
