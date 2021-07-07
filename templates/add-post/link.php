<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty(array_column($errors, 'post-link')) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="post-link" type="text" name="post-link" placeholder="Введите ссылку">
        <?= !empty(array_column($errors, 'post-link')) ? show_field_errors(array_column($errors, 'post-link')) : ''; ?>
    </div>
</div>
