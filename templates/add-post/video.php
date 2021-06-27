<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty($errors['video-heading']) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="video-url" type="text" name="video-heading" placeholder="Введите ссылку">
        <?= !empty($errors['video-heading']) ? show_field_errors($errors['video-heading']) : ''; ?>
    </div>
</div>
