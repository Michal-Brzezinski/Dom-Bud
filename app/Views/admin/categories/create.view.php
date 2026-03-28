<link rel="stylesheet" href="<?= asset('css/base/variables.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/fonts.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/buttons.css') ?>">

<h1>Dodaj kategorię</h1>

<p><a href="/admin/categories">← Wróć do listy</a></p>

<form method="post" action="/admin/categories/store" class="form">

    <div class="form-group">
        <label>Nazwa:</label>
        <input type="text" name="name" required>
    </div>

    <div class="form-group">
        <label>Slug (opcjonalnie, wygeneruje się z nazwy):</label>
        <input type="text" name="slug">
    </div>

    <div class="form-group">
        <label>Opis:</label>
        <textarea name="description"></textarea>
    </div>

    <div class="form-group">
        <label>Ścieżka obrazu:</label>
        <input type="text" name="image_path" placeholder="np. img/categories/chemia-budowlana.webp">
    </div>

    <button class="btn" type="submit">Zapisz</button>
</form>