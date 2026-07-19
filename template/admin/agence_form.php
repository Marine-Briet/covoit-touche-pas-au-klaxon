<?php
// $agence est null en création, ou un tableau (agence existante) en modification
$isEdit = $agence !== null;
$actionUrl = $isEdit
    ? BASE_URL . '/admin/agences/edit/' . $agence['id_agence']
    : BASE_URL . '/admin/agences/create';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? 'Modifier' : 'Créer' ?> une agence - Touche pas au klaxon</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div class="container mt-4">
        <?php require __DIR__ . '/../partials/header.php'; ?>
        <?php require __DIR__ . '/../partials/flash.php'; ?>

        <h2 class="h5 mb-3"><?= $isEdit ? 'Modifier' : 'Créer' ?> une agence</h2>

        <form method="POST" action="<?= $actionUrl ?>">
            <div class="mb-3">
                <label for="nom_ville" class="form-label">Nom de la ville</label>
                <input type="text" class="form-control" id="nom_ville" name="nom_ville"
                       value="<?= $isEdit ? htmlspecialchars($agence['nom_ville']) : '' ?>" required>
            </div>
            <button type="submit" class="btn btn-dark"><?= $isEdit ? 'Modifier' : 'Créer' ?></button>
        </form>
    </div>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>