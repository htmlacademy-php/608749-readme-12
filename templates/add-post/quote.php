<div class="adding-post__input-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= array_key_exists('cite-text', $errors) ? 'form__input-section--error' : '' ?>">
        <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" placeholder="Текст цитаты"></textarea>
        <!-- @todo вынести это условие в функцию, потому что оно всегда повторяется!!! -->
        <?php if (array_key_exists('cite-text', $errors)): ?>
            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
            <div class="form__error-text">
                <h3 class="form__error-title"><?= $errors['cite-text']['title'] ?></h3>
                <p class="form__error-desc"><?= $errors['cite-text']['description'] ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= array_key_exists('quote-author', $errors) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author" placeholder="Автор цитаты">
        <?php if (array_key_exists('quote-author', $errors)): ?>
            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
            <div class="form__error-text">
                <h3 class="form__error-title"><?= $errors['quote-author']['title'] ?></h3>
                <p class="form__error-desc"><?= $errors['quote-author']['description'] ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
