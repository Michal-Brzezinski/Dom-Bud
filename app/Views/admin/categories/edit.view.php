<link rel="stylesheet" href="<?= asset('css/base/variables.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/fonts.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>">

<div class="admin-container">

    <h1>Edytuj kategorię</h1>

    <?php if (isset($_GET['error'])): ?>
        <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <a class="btn-outline" href="/admin/categories">← Wróć do listy</a>

    <?php if ($category->has_draft): ?>
        <div class="info_card">
            <strong>Uwaga:</strong> Edytujesz obecnie niezapisaną wersję roboczą.
            <form class="inline" method="post" action="/admin/categories/publish" style="display:inline-block; margin-left:10px;">
                <input type="hidden" name="id" value="<?= e($category->id) ?>">
                <button class="btn" type="submit" style="padding: 5px 10px; font-size:12px;">Opublikuj ten szkic</button>
            </form>
        </div>
    <?php endif; ?>

    <form method="post" action="/admin/categories/update" class="admin-card">

        <input type="hidden" name="id" value="<?= e($category->id) ?>">

        <div class="form-group">
            <label>Nazwa:</label>
            <input type="text" name="name" value="<?= e($category->has_draft ? $category->draft_name : $category->name) ?>" required>
        </div>

        <div class="form-group">
            <label>Slug:</label>
            <input type="text" name="slug" value="<?= e($category->has_draft ? $category->draft_slug : $category->slug) ?>">
        </div>

        <div class="form-group">
            <label>Kategoria nadrzędna:</label>
            <select name="parent_id">
                <option value="">Brak (kategoria główna)</option>

                <?php
                $currentParentId = $category->has_draft ? $category->draft_parent_id : $category->parent_id;
                foreach ($categories as $c):
                ?>
                    <?php if ($c->id === $category->id) continue; ?>
                    <option value="<?= e($c->id) ?>" <?= $currentParentId == $c->id ? 'selected' : '' ?>>
                        <?= e($c->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Opis:</label>
            <textarea name="description"><?= e($category->has_draft ? $category->draft_description : $category->description) ?></textarea>
        </div>

        <div class="form-group">
            <?php include __DIR__ . '/../../partials/image-upload.php'; ?>
        </div>

        <button class="btn" type="submit">Zapisz jako wersję roboczą</button>
    </form>

</div>

<script src="<?= asset('js/admin/category-upload.js') ?>"></script>