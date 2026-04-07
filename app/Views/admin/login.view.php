<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Logowanie — Panel Admina</title>
    <link rel="stylesheet" href="<?= asset('css/admin/login.css') ?>">
    <link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
</head>

<body>

    <div class="login-container">
        <h2>Panel administracyjny</h2>

        <?php if (!empty($error)): ?>
            <div class="login-error">
                <?php if ($error === 'empty'): ?>
                    Wypełnij wszystkie pola.
                <?php elseif ($error === 'invalid'): ?>
                    Nieprawidłowy email lub hasło.
                <?php else: ?>
                    Wystąpił nieznany błąd.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" class="login-form">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Hasło:</label>
            <input type="password" name="password" required>

            <button type="submit">Zaloguj się</button>
        </form>
    </div>

</body>

</html>