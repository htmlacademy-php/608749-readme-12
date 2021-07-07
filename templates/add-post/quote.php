<div class="adding-post__input-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty(array_column($errors, 'cite-text')) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" placeholder="Текст цитаты"></textarea>
        <?= !empty(array_column($errors, 'cite-text')) ? show_field_errors(array_column($errors, 'cite-text')) : ''; ?>
    </div>
</div>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= !empty(array_column($errors, 'quote-author')) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author" placeholder="Автор цитаты">
        <?= !empty(array_column($errors, 'quote-author')) ? show_field_errors(array_column($errors, 'quote-author')) : ''; ?>
    </div>
</div>
