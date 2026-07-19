<?php
/**
 * Vue : Modification d'un trajet
 * Variables attendues : $trajet, $agences
 */
$user = $_SESSION['user'];

// Format attendu par l'input datetime-local : "2026-08-01T08:00"
$dateDepartFormatted = (new DateTime($trajet['date_depart']))->format('Y-m-d\TH:i');
$dateArriveeFormatted = (new DateTime($trajet['date_arrivee']))->format('Y-m-d\TH:i');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le trajet - Touche pas au klaxon</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

    <div class="container mt-4">

        <?php require __DIR__ . '/partials/header.php'; ?>
        <?php require __DIR__ . '/partials/flash.php'; ?>

        <h2 class="h5 mb-3">Modifier le trajet</h2>

        <form method="POST" action="<?= BASE_URL ?>/trajet/edit/<?= $trajet['id_trajet'] ?>">

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
                            <?php foreach ($agences as $agence): ?>
                                <option value="<?= $agence['id_agence'] ?>"
                                    <?= $agence['id_agence'] === $trajet['id_agence_depart'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agence['nom_ville']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_agence_arrivee" class="form-label">Agence d'arrivée</label>
                        <select class="form-select" id="id_agence_arrivee" name="id_agence_arrivee" required>
                            <?php foreach ($agences as $agence): ?>
                                <option value="<?= $agence['id_agence'] ?>"
                                    <?= $agence['id_agence'] === $trajet['id_agence_arrivee'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agence['nom_ville']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_depart" class="form-label">Date et heure de départ</label>
                        <input type="datetime-local" class="form-control" id="date_depart" name="date_depart"
                               value="<?= $dateDepartFormatted ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_arrivee" class="form-label">Date et heure d'arrivée</label>
                        <input type="datetime-local" class="form-control" id="date_arrivee" name="date_arrivee"
                               value="<?= $dateArriveeFormatted ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nb_places_tot" class="form-label">Nombre total de places</label>
                        <input type="number" class="form-control" id="nb_places_tot" name="nb_places_tot"
                               min="1" value="<?= (int) $trajet['nb_places_tot'] ?>" required>
                    </div>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-dark">Modifier le trajet</button>

        </form>

    </div>

    <?php require __DIR__ . '/partials/footer.php'; ?>

</body>
</html>