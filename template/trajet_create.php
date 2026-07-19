<?php
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un trajet - Touche pas au klaxon</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

    <div class="container mt-4">

        <?php require __DIR__ . '/partials/header.php'; ?>
        <?php require __DIR__ . '/partials/flash.php'; ?>

        <h2 class="h5 mb-3">Créer un trajet</h2>

        <form method="POST" action="<?= BASE_URL ?>/trajet/create">

            <fieldset class="mb-4">
                <legend class="h6">Vos informations</legend>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['prenom']) ?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['telephone']) ?>" disabled>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend class="h6">Détails du trajet</legend>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_agence_depart" class="form-label">Agence de départ</label>
                        <select class="form-select" id="id_agence_depart" name="id_agence_depart" required>
                            <option value="">-- Choisir --</option>
                            <?php foreach ($agences as $agence): ?>
                                <option value="<?= $agence['id_agence'] ?>">
                                    <?= htmlspecialchars($agence['nom_ville']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_agence_arrivee" class="form-label">Agence d'arrivée</label>
                        <select class="form-select" id="id_agence_arrivee" name="id_agence_arrivee" required>
                            <option value="">-- Choisir --</option>
                            <?php foreach ($agences as $agence): ?>
                                <option value="<?= $agence['id_agence'] ?>">
                                    <?= htmlspecialchars($agence['nom_ville']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_depart" class="form-label">Date et heure de départ</label>
                        <input type="datetime-local" class="form-control" id="date_depart" name="date_depart" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_arrivee" class="form-label">Date et heure d'arrivée</label>
                        <input type="datetime-local" class="form-control" id="date_arrivee" name="date_arrivee" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nb_places_tot" class="form-label">Nombre total de places</label>
                        <input type="number" class="form-control" id="nb_places_tot" name="nb_places_tot" min="1" required>
                    </div>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-dark">Proposer le trajet</button>

        </form>

    </div>

    <?php require __DIR__ . '/partials/footer.php'; ?>

</body>
</html>