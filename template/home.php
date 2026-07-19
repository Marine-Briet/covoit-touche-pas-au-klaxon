<?php
/**
 * Vue : Page d'accueil
 * Variable attendue : $trajets
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="container mt-4">

        <?php require __DIR__ . '/partials/header.php'; ?>

        <h2 class="h5 mb-3">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h2>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Départ</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Places</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($trajets)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun trajet disponible pour le moment.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($trajets as $trajet): ?>
                        <?php
                            $dateDepart = new DateTime($trajet['date_depart']);
                            $dateArrivee = new DateTime($trajet['date_arrivee']);
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                            <td><?= $dateDepart->format('d/m/y') ?></td>
                            <td><?= $dateDepart->format('H:i') ?></td>
                            <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                            <td><?= $dateArrivee->format('d/m/y') ?></td>
                            <td><?= $dateArrivee->format('H:i') ?></td>
                            <td><?= (int) $trajet['nb_places_dispo'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <?php require __DIR__ . '/partials/footer.php'; ?>

</body>
</html>