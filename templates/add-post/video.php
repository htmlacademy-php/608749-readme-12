<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty(array_column($errors, 'video-heading')) ? 'form__input-section--error' : '' ?>">
        <input
            class="adding-post__input form__input"
            id="video-url"
            type="text"
            name="video-heading"
            placeholder="Введите ссылку"
            value="<?= $values['video-heading'] ?? ''; ?>"
        >
        <?= !empty(array_column($errors, 'video-heading')) ? show_field_errors(array_column($errors, 'video-heading')) : ''; ?>
    </div>
</div>
