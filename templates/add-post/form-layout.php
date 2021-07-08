<section class="adding-post__text tabs__content tabs__content--active">
    <h2 class="visually-hidden"><?= $form_title; ?></h2>
    <form class="adding-post__form form" action="/new-post.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="active-type" value="<?= $active_type ?>" />
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="text-heading">Заголовок <span class="form__input-required">*</span></label>
                    <div class="form__input-section <?= !empty(array_column($errors, 'text-heading')) ? 'form__input-section--error' : ''; ?>">
                        <input
                            class="adding-post__input form__input"
                            id="text-heading"
                            type="text"
                            name="text-heading"
                            placeholder="Введите заголовок"
                            value="<?= $values['text-heading'] ?? ''; ?>"
                        >
                        <?= !empty(array_column($errors, 'text-heading')) ? show_field_errors(array_column($errors, 'text-heading')) : ''; ?>
                    </div>
                </div>
                <?= add_form_fields($active_type, $errors, $values); ?>
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="post-tags">Теги</label>
                    <div class="form__input-section <?= !empty(array_column($errors, 'post-tags')) ? 'form__input-section--error' : ''?>">
                        <input
                            class="adding-post__input form__input"
                            id="post-tags" type="text"
                            name="post-tags"
                            placeholder="Введите теги"
                            value="<?= $values['post-tags'] ?? ''; ?>"
                        >
                        <?= !empty(array_column($errors, 'post-tags')) ? show_field_errors(array_column($errors, 'post-tags')) : ''; ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($errors)): ?>
            <div class="form__invalid-block">
                <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                <ul class="form__invalid-list">
                    <?php foreach ($errors as $field_errors): ?>
                        <?php foreach ($field_errors as $error): ?>
                            <li class="form__invalid-item"><?= $error['title']; ?>. <?= $error['description']; ?>.</li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($active_type === 'photo'): ?>
            <div class="adding-post__input-file-container form__input-container form__input-container--file">
            <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                    <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="userpic-file-photo" title=" ">
                    <div class="form__file-zone-text">
                        <span>Перетащите фото сюда</span>
                    </div>
                </div>
                <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                    <span>Выбрать фото</span>
                    <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                        <use xlink:href="#icon-attach"></use>
                    </svg>
                </button>
            </div>
            <div class="adding-post__file adding-post__file--photo form__file dropzone-previews"></div>
        </div>
        <?php endif; ?>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
            <a class="adding-post__close" href="/">Закрыть</a>
        </div>
    </form>
</section>
