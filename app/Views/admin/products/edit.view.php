<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
<title>Edytuj produkt</title>
<link rel="stylesheet" href="<?= asset('css/admin/_import.css') ?>">

<div class="admin-container">

    <h1>Edytuj produkt: <?= e($product->name) ?></h1>

    <p>
        <a href="/admin/categories/<?= e($product->category_slug) ?>/products">
            ← Wróć do listy produktów
        </a>
    </p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error_card">
            <?= e($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <form id="product-edit-form" method="post" action="/admin/products/update" class="admin-card">

        <input type="hidden" name="id" value="<?= e($product->id) ?>">

        <div class="form-group">
            <label>Nazwa produktu:</label>
            <input type="text" name="name" value="<?= e($product->name) ?>" required>
        </div>

        <div class="form-group">
            <label>Cena (PLN):</label>
            <input type="number" step="0.01" min="0" name="price"
                value="<?= number_format($product->price, 2, '.', '') ?>" required>
        </div>

        <div class="form-group">
            <label>Opis:</label>
            <textarea name="description"><?= e($product->description) ?></textarea>
        </div>

        <div class="form-group">
            <label>Właściwości (JSON):</label>
            <textarea name="properties"><?= e(json_encode($product->properties, JSON_UNESCAPED_UNICODE)) ?></textarea>
        </div>

    </form>

    <h2>Zdjęcia produktu</h2>

    <div class="admin-card">

        <?php if (empty($product->images)): ?>
            <div class="info_card">Brak zdjęć produktu.</div>
        <?php else: ?>

            <div class="product-images-grid">

                <?php foreach ($product->images as $img): ?>
                    <div class="product-image-item">

                        <img src="/<?= e($img->path) ?>" alt="" class="product-image-thumb">

                        <?php if ($img->is_main): ?>
                            <div class="badge-main">Główne</div>
                        <?php endif; ?>

                        <button
                            class="btn-small js-set-main"
                            data-product-id="<?= e($product->id) ?>"
                            data-image-id="<?= e($img->id) ?>">
                            Ustaw jako główne
                        </button>
                        <button
                            class="btn-danger-small js-delete-image"
                            data-product-id="<?= e($product->id) ?>"
                            data-image-id="<?= e($img->id) ?>">
                            Usuń
                        </button>

                    </div>
                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <h3>Dodaj nowe zdjęcia</h3>

        <div id="product-dropzone" data-product-id="<?= e($product->id) ?>" class="dropzone">
            Kliknij lub przeciągnij pliki tutaj
        </div>

        <script src="<?= asset('js/admin/product-upload.js') ?>"></script>

    </div>

    <br><br>
    <button class="btn" type="submit" form="product-edit-form">
        Zapisz zmiany
    </button>


</div>