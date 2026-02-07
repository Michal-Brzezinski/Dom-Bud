<form method="get" class="catalog-controls">

    <div class="catalog-controls__search-wrapper">
        <input
            type="text"
            name="q"
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
            class="catalog-controls__search"
            placeholder="Wyszukaj produkt...">

        <button type="submit" class="catalog-controls__search-btn" aria-label="Szukaj">
            <svg
                class="catalog-controls__search-icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>
    </div>

    <select name="sort" class="catalog-controls__sort" onchange="this.form.submit()">
        <option value="az" <?= ($_GET['sort'] ?? 'az') === 'az' ? 'selected' : '' ?>>
            Sortuj: A → Z
        </option>
        <option value="za" <?= ($_GET['sort'] ?? 'az') === 'za' ? 'selected' : '' ?>>
            Sortuj: Z → A
        </option>
    </select>

</form>