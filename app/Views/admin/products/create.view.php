<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
<title>Dodaj produkt</title>
<link rel="stylesheet" href="<?= asset('css/admin/_import.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/products/properties.css') ?>">

<div class="admin-container">

    <h1>Dodaj produkt do kategorii: <?= e($category->name) ?></h1>

    <p>
        <a href="/admin/products?category_id=<?= e($category->id) ?>" class="back-link">
            ← Wróć do listy produktów
        </a>
    </p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error_card">
            <?= e($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <!-- FORMULARZ PRODUKTU -->
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
            <label>Właściwości:</label>
            <?php
            $propertiesJson = "{}";
            include ROOT_PATH . "/app/Views/partials/admin/product-properties.php";
            ?>
        </div>

        <!-- HIDDEN: ID zdjęcia głównego (tymczasowego) -->
        <input type="hidden" name="temp_main_image" id="temp_main_image">

    </form>

    <!-- ZDJĘCIA PRODUKTU (TRYB CREATE) -->
    <h2>Zdjęcia produktu</h2>

    <div class="admin-card">

        <div id="temp-images-preview" class="product-images-grid"></div>

        <h3>Dodaj nowe zdjęcia</h3>

        <div id="product-dropzone-temp"
            data-category-id="<?= e($category->id) ?>"
            class="dropzone">
            Kliknij lub przeciągnij pliki tutaj
        </div>

        <script>
            const TEMP_SESSION_ID = "<?= session_id() ?>";
        </script>
        <script src="<?= asset('js/admin/product-upload-temp.js') ?>"></script>
        <script src="<?= asset('js/admin/product-properties.js') ?>"></script>
        <script src="<?= asset('js/admin/clear-tmp.js') ?>"></script>

    </div>

    <br><br>
    <button class="btn" type="submit" form="product-create-form">
        Zapisz produkt
    </button>

</div>