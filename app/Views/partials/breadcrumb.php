<?php if (!empty($breadcrumb)): ?>
    <nav class="breadcrumb">
        <a href="<?= url('katalog') ?>">Oferta</a>

        <?php
        $last = end($breadcrumb);
        reset($breadcrumb);
        ?>

        <?php foreach ($breadcrumb as $item): ?>
            <span class="breadcrumb-separator">›</span>

            <?php $slug = $item->slug ?? null; ?>

            <?php if ($item === $last): ?>
                <span><?= htmlspecialchars($item->name) ?></span>
            <?php else: ?>
                <a href="<?= url('katalog/' . $slug) ?>">
                    <?= htmlspecialchars($item->name) ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>