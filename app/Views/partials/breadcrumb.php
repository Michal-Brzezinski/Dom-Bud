<?php if (!empty($breadcrumb)): ?>
    <nav class="breadcrumb">
        <a href="<?= url('katalog') ?>">Oferta</a>

        <?php
        $last = end($breadcrumb);
        reset($breadcrumb);
        ?>

        <?php foreach ($breadcrumb as $item): ?>
            <span class="breadcrumb-separator">›</span>

            <?php if ($item->id === $last->id): ?>
                <span><?= htmlspecialchars($item->name) ?></span>
            <?php else: ?>
                <a href="<?= url('katalog/' . $item->slug) ?>">
                    <?= htmlspecialchars($item->name) ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>