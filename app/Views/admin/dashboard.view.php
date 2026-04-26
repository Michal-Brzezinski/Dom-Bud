<link rel="stylesheet" href="<?= asset('css/admin/_import.css') ?>">
<title>Panel administratora</title>
<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">

<div class="admin-wrapper">
    <div class="admin-card">
        <h1>Panel administratora</h1>
        <p class="admin-subtitle">Zarządzaj zawartością systemu</p>

        <div class="admin-actions">
            <a href="/admin/categories" class="btn btn-primary">
                Zarządzaj kategoriami i produktami
            </a>

            <a href="/admin/logout" class="btn btn-danger">
                Wyloguj
            </a>
        </div>
    </div>
</div>