<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Touche pas au klaxon</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="container mt-4">

        <?php require __DIR__ . '/partials/header.php'; ?>

        <div class="row justify-content-center mt-5">
            <div class="col-md-4">

                <h2 class="h5 mb-3">Connexion</h2>

                <?php require __DIR__ . '/partials/flash.php'; ?>

                <form method="POST" action="login">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                    </div>
                    <button type="submit" class="btn btn-dark">Se connecter</button>
                </form>

            </div>
        </div>

    </div>

   <?php require __DIR__ . '/partials/footer.php'; ?>

</body>
</html>