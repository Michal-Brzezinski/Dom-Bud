<link rel="stylesheet" href="<?= asset('css/base/variables.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/fonts.css') ?>">
<link rel="stylesheet" href="<?= asset('css/base/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/buttons.css') ?>">

<div class="admin-wrapper">
    <div class="admin-card">
        <h1>Panel administratora</h1>
        <p class="admin-subtitle">Zarządzaj zawartością systemu</p>

        <div class="admin-actions">
            <a href="/admin/categories" class="btn btn-primary">
                Zarządzaj kategoriami
            </a>

            <a href="/admin/logout" class="btn btn-danger">
                Wyloguj
            </a>
        </div>
    </div>
</div>