<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
<title>Dodaj produkt</title>
<link rel="stylesheet" href="<?= asset('css/admin/_import.css') ?>">

<div class="admin-container">

    <h1>Dodaj produkt do kategorii: <?= e($category->name) ?></h1>

    <p><a href="/admin/products?category_id=<?= e($category->id) ?>">← Wróć do listy produktów</a></p>

    <!-- FORMULARZ DODAWANIA PRODUKTU -->
    <form id="product-create-form" method="post" action="/admin/products/store" class="admin-card">

        <input type="hidden" name="category_id" value="<?= e($category->id) ?>">

        <div class="form-group">
            <label>Nazwa produktu:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Cena (PLN):</label>
            <input type="number" step="0.01" min="0" name="price" required>
        </div>

        <div class="form-group">
            <label>Opis:</label>
            <textarea name="description"></textarea>
        </div>

        <div class="form-group">
            <label>Właściwości (JSON lub puste):</label>
            <textarea name="properties" placeholder='np. {"waga":"500g","kolor":"szary"}'></textarea>
        </div>

    </form>

    <h3>Zdjęcia produktu</h3>

    <div id="product-dropzone-temp" class="dropzone">
        Kliknij lub przeciągnij pliki tutaj
    </div>

    <div id="temp-images-preview" class="product-images-grid"></div>

    <!-- PRZYCISK NA DOLE, ALE WYSYŁA FORMULARZ POWYŻEJ -->
    <button class="btn" type="submit" form="product-create-form">
        Zapisz produkt
    </button>

    <script src="<?= asset('js/admin/product-upload-temp.js') ?>"></script>

</div>