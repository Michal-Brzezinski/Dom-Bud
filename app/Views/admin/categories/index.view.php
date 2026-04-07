<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
<title>Kategorie</title>
<link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>">

<div class="admin-container">

    <h1>Kategorie</h1>

    <?php if (isset($_GET['error'])): ?>
        <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <p><a href="/admin">← Panel główny</a></p>
    <p><a class="btn" href="/admin/categories/create">+ Dodaj kategorię</a></p>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Zdjęcie</th>
                    <th>Nazwa</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td>
                            <?php if ($cat->image_path): ?>
                                <img src="/<?= e($cat->image_path) ?>" style="width:60px; height:auto;">
                            <?php endif; ?>
                        </td>
                        <td><?= e($cat->name) ?></td>
                        <td><?= e($cat->slug) ?></td>
                        <td>
                            <?php if ($cat->has_draft): ?>
                                <span style="color: orange; font-weight:bold;">Posiada szkic</span>
                            <?php else: ?>
                                <span style="color: green;">Opublikowana</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions-wrapper">
                                <a class="btn" href="/admin/categories/<?= e($cat->slug) ?>/edit">Edytuj</a>

                                <?php
                                $hasChildren = false;
                                foreach ($categories as $c2) {
                                    if ($c2->parent_id === $cat->id) {
                                        $hasChildren = true;
                                        break;
                                    }
                                }
                                ?>

                                <?php if (!$hasChildren): ?>
                                    <a class="btn" href="/admin/categories/<?= e($cat->slug) ?>/products">
                                        Produkty
                                    </a>
                                <?php endif; ?>


                                <form class="inline" method="post" action="/admin/categories/delete"
                                    onsubmit="return confirm('Usunąć kategorię i wszystkie produkty?');">
                                    <input type="hidden" name="id" value="<?= $cat->id ?>">
                                    <button class="btn-danger" type="submit">Usuń</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>