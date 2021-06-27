<div class="adding-post__textarea-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= array_key_exists('post-text', $errors) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" placeholder="Введите текст публикации"></textarea>
        <?= array_key_exists('post-text', $errors) ? show_field_errors($errors['post-text']) : ''; ?>
    </div>
</div>
