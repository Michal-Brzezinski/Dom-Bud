<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
<title>Produkty</title>
<link rel="stylesheet" href="<?= asset('css/admin/_import.css') ?>">

<div class="admin-container">

    <h1>Produkty w kategorii: <?= e($category->name) ?></h1>

    <p><a href="/admin/categories">← Wróć do kategorii</a></p>

    <p>
        <a class="btn" href="/admin/products/create?category_id=<?= e($category->id) ?>">
            + Dodaj produkt
        </a>
    </p>

    <?php if (empty($products)): ?>
        <div class="info_card">
            Brak produktów w tej kategorii.
        </div>
    <?php else: ?>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Zdjęcie</th>
                        <th>Nazwa</th>
                        <th>Cena</th>
                        <th>Opis</th>
                        <th>Akcje</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <?php if ($p->main_image_path): ?>
                                    <img src="/<?= e($p->main_image_path) ?>" style="width:60px; height:auto;">
                                <?php endif; ?>
                            </td>
                            <td><?= e($p->name) ?></td>
                            <td><?= number_format($p->price, 2) ?> zł</td>
                            <td><?= e(mb_strimwidth($p->description ?? '', 0, 40, '...')) ?></td>

                            <td>
                                <div class="actions-wrapper">
                                    <a class="btn" href="/admin/products/edit?id=<?= e($p->id) ?>">Edytuj</a>

                                    <form method="post" action="/admin/products/delete"
                                        onsubmit="return confirm('Usunąć produkt i wszystkie jego zdjęcia?');">
                                        <input type="hidden" name="id" value="<?= e($p->id) ?>">
                                        <button class="btn-danger" type="submit">Usuń</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    <?php endif; ?>

</div>