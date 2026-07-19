<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Trajets - Touche pas au klaxon</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div class="container mt-4">
        <?php require __DIR__ . '/../partials/header.php'; ?>
        <?php require __DIR__ . '/../partials/flash.php'; ?>

        <h2 class="h5 mb-3">Trajets</h2>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Auteur</th>
                    <th>Départ</th>
                    <th>Date départ</th>
                    <th>Arrivée</th>
                    <th>Date arrivée</th>
                    <th>Places</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $trajet): ?>
                    <?php
                        $dateDepart = new DateTime($trajet['date_depart']);
                        $dateArrivee = new DateTime($trajet['date_arrivee']);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['prenom']) ?> <?= htmlspecialchars($trajet['nom']) ?></td>
                        <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                        <td><?= $dateDepart->format('d/m/y H:i') ?></td>
                        <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                        <td><?= $dateArrivee->format('d/m/y H:i') ?></td>
                        <td><?= (int) $trajet['nb_places_dispo'] ?> / <?= (int) $trajet['nb_places_tot'] ?></td>
                        <td>
                            <form method="POST" action="<?= BASE_URL ?>/admin/trajets/delete/<?= $trajet['id_trajet'] ?>" class="d-inline">
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