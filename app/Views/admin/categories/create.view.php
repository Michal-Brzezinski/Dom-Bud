<link rel="stylesheet" href="<?= asset('css/base/variables.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/fonts.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>">

<h1>Dodaj kategorię</h1>

<?php if (isset($_GET['error'])): ?>
    <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<p><a href="/admin/categories">← Wróć do listy</a></p>

<form method="post" action="/admin/categories/store" class="form">

    <div class="form-group">
        <label>Nazwa:</label>
        <input type="text" name="name" required>
    </div>

    <label>Kategoria nadrzędna:</label>
    <select name="parent_id">
        <option value="">Brak (kategoria główna)</option>
        <?php foreach ($categories as $c): ?>
            <option value="<?= e($c->id) ?>"><?= e($c->name) ?></option>
        <?php endforeach; ?>
    </select>

    <div class="form-group">
        <label>Slug (opcjonalnie, wygeneruje się z nazwy):</label>
        <input type="text" name="slug">
    </div>

    <div class="form-group">
        <label>Opis:</label>
        <textarea name="description"></textarea>
    </div>

    <div class="form-group">
        <?php include __DIR__ . '/../../partials/image-upload.php'; ?>
    </div>

    <button class="btn" type="submit">Zapisz jako opublikowaną</button>
</form>

<script src="<?= asset('js/admin/category-upload.js') ?>"></script>