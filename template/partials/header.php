<?php
// Header dynamique selon l'état de connexion
$isConnected = !empty($_SESSION['user']);
$isAdmin = $isConnected && $_SESSION['user']['est_admin'];
?>

<div class="d-flex justify-content-between align-items-center border rounded p-3 mb-4">

    <a href="<?= BASE_URL ?>/" class="h4 mb-0 text-decoration-none text-dark">Touche pas au klaxon</a>

    <div>
        <?php if ($isAdmin): ?>
            <a href="<?= BASE_URL ?>/admin/utilisateurs" class="btn btn-secondary">Utilisateurs</a>
            <a href="<?= BASE_URL ?>/admin/agences" class="btn btn-secondary">Agences</a>
            <a href="<?= BASE_URL ?>/admin/trajets" class="btn btn-secondary">Trajets</a>
            <span class="mx-2">Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) ?> <?= htmlspecialchars($_SESSION['user']['nom']) ?></span>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-dark">Déconnexion</a>

        <?php elseif ($isConnected): ?>
            <a href="<?= BASE_URL ?>/trajet/create" class="btn btn-dark">Créer un trajet</a>
            <span class="mx-2">Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) ?> <?= htmlspecialchars($_SESSION['user']['nom']) ?></span>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-dark">Déconnexion</a>

        <?php else: ?>
            <a href="<?= BASE_URL ?>/login" class="btn btn-dark">Connexion</a>
        <?php endif; ?>
    </div>

</div>