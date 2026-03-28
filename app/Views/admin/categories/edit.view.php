<link rel="stylesheet" href="<?= asset('css/base/variables.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/fonts.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/buttons.css') ?>">

<h1>Edytuj kategorię</h1>

<p><a href="/admin/categories">← Wróć do listy</a></p>

<form method="post" action="/admin/categories/update" class="form">

    <input type="hidden" name="id" value="<?= e($category->id) ?>">

    <div class="form-group">
        <label>Nazwa:</label>
        <input type="text" name="name" value="<?= e($category->name) ?>" required>
    </div>

    <div class="form-group">
        <label>Slug:</label>
        <input type="text" name="slug" value="<?= e($category->slug) ?>">
    </div>

    <div class="form-group">
        <label>Opis:</label>
        <textarea name="description"><?= e($category->description) ?></textarea>
    </div>

    <div class="form-group">
        <label>Ścieżka obrazu:</label>
        <input type="text" name="image_path" value="<?= e($category->image_path) ?>">
    </div>

    <button class="btn" type="submit">Zapisz</button>
</form>