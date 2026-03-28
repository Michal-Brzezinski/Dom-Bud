<link rel="stylesheet" href="<?= asset('css/base/variables.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/fonts.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/buttons.css') ?>">

<div class="admin-container">

    <h1>Kategorie</h1>

    <p><a href="/admin">← Panel główny</a></p>
    <p><a class="btn" href="/admin/categories/create">+ Dodaj kategorię</a></p>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Slug</th>
                    <th>Opis</th>
                    <th>Obraz</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= e($cat->id) ?></td>
                        <td><?= e($cat->name) ?></td>
                        <td><?= e($cat->slug) ?></td>
                        <td><?= e($cat->description) ?></td>
                        <td><?= e($cat->image_path) ?></td>
                        <td class="actions">
                            <a class="btn" href="/admin/categories/edit?id=<?= $cat->id ?>">Edytuj</a>

                            <form class="inline" method="post" action="/admin/categories/delete"
                                onsubmit="return confirm('Usunąć kategorię i wszystkie produkty?');">
                                <input type="hidden" name="id" value="<?= $cat->id ?>">
                                <button class="btn-danger" type="submit">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>