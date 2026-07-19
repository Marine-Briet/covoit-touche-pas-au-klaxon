<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord admin - Touche pas au klaxon</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div class="container mt-4">
        <?php require __DIR__ . '/../partials/header.php'; ?>
        <?php require __DIR__ . '/../partials/flash.php'; ?>

        <h2 class="h5 mb-3">Tableau de bord administrateur</h2>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL ?>/admin/utilisateurs" class="btn btn-secondary">Utilisateurs</a>
            <a href="<?= BASE_URL ?>/admin/agences" class="btn btn-secondary">Agences</a>
            <a href="<?= BASE_URL ?>/admin/trajets" class="btn btn-secondary">Trajets</a>
        </div>
    </div>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>