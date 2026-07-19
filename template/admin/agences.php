<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Agences - Touche pas au klaxon</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div class="container mt-4">
        <?php require __DIR__ . '/../partials/header.php'; ?>
        <?php require __DIR__ . '/../partials/flash.php'; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">Agences</h2>
            <a href="<?= BASE_URL ?>/admin/agences/create" class="btn btn-dark">Créer une agence</a>
        </div>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Ville</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agences as $agence): ?>
                    <tr>
                        <td><?= htmlspecialchars($agence['nom_ville']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/agences/edit/<?= $agence['id_agence'] ?>" class="me-2 text-decoration-none">✏️</a>
                            <form method="POST" action="<?= BASE_URL ?>/admin/agences/delete/<?= $agence['id_agence'] ?>" class="d-inline">
                                <button type="submit" class="btn btn-link p-0 text-decoration-none">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>