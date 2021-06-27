 <div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section <?= !empty($errors['photo-heading']) ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-heading" placeholder="Введите ссылку">
        <?= !empty($errors['photo-heading']) ? show_field_errors($errors['photo-heading']) : ''; ?>
    </div>
</div>
