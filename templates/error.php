<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Ошибка соединения с базой данных</h1>
    <section class="search">
        <div class="search__results-wrapper">
            <div class="search__no-results container">
                <p class="search__no-results-info">Извините, произошла ошибка</p>
                <p class="search__no-results-desc">
                    <?= $error; ?>
                </p>
                <p class="search__no-results-desc">
                    Невозможно установить соединение с базой данных. Пожалуйста, попробуйте позже.
                </p>
                <div class="search__links">
                    <a class="search__popular-link button button--main" href="#">Популярное</a>
                    <a class="search__back-link" href="#">Вернуться назад</a>
                </div>
            </div>
        </div>
    </section>
</main>
