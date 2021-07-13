<div class="adding-post__textarea-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty(array_column($errors, 'post-text')) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea form__textarea form__input" name="post-text" id="post-text" placeholder="Введите текст публикации"><?= $values['post-text'] ?? ''; ?></textarea>
        <?= !empty(array_column($errors, 'post-text')) ? show_field_errors(array_column($errors, 'post-text')) : ''; ?>
    </div>
</div>
