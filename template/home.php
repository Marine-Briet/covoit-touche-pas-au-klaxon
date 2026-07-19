<?php
$isConnected = !empty($_SESSION['user']);
$userId = $isConnected ? $_SESSION['user']['id_utilisateur'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

    <div class="container mt-4">

        <?php require __DIR__ . '/partials/header.php'; ?>
        <?php require __DIR__ . '/partials/flash.php'; ?>

        <?php if ($isConnected): ?>
            <h2 class="h5 mb-3">Trajets proposés</h2>
        <?php else: ?>
            <h2 class="h5 mb-3">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h2>
        <?php endif; ?>

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
                    <?php if ($isConnected): ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($trajets)): ?>
                    <tr>
                        <td colspan="<?= $isConnected ? 8 : 7 ?>" class="text-center">Aucun trajet disponible pour le moment.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($trajets as $trajet): ?>
                        <?php
                            $dateDepart = new DateTime($trajet['date_depart']);
                            $dateArrivee = new DateTime($trajet['date_arrivee']);
                            $isAuthor = $isConnected && $trajet['id_utilisateur'] === $userId;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                            <td><?= $dateDepart->format('d/m/y') ?></td>
                            <td><?= $dateDepart->format('H:i') ?></td>
                            <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                            <td><?= $dateArrivee->format('d/m/y') ?></td>
                            <td><?= $dateArrivee->format('H:i') ?></td>
                            <td><?= (int) $trajet['nb_places_dispo'] ?></td>

                            <?php if ($isConnected): ?>
                                <td>
                                    
                                    <button type="button" class="btn btn-link p-0 me-2 text-decoration-none"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetails<?= $trajet['id_trajet'] ?>">
                                        👁
                                    </button>

                                    <?php if ($isAuthor): ?>
                                        <a href="<?= BASE_URL ?>/trajet/edit/<?= $trajet['id_trajet'] ?>" class="me-2 text-decoration-none">✏️</a>
                                        <form method="POST" action="<?= BASE_URL ?>/trajet/delete/<?= $trajet['id_trajet'] ?>" class="d-inline">
                                            <button type="submit" class="btn btn-link p-0 text-decoration-none">🗑️</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <?php if ($isConnected): ?>
                            <!-- Modale de détails pour ce trajet -->
                            <div class="modal fade" id="modalDetails<?= $trajet['id_trajet'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Détails du trajet</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Auteur :</strong> <?= htmlspecialchars($trajet['prenom']) ?> <?= htmlspecialchars($trajet['nom']) ?></p>
                                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['telephone']) ?></p>
                                            <p><strong>Email :</strong> <?= htmlspecialchars($trajet['email']) ?></p>
                                            <p><strong>Nombre total de places :</strong> <?= (int) $trajet['nb_places_tot'] ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <?php require __DIR__ . '/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>