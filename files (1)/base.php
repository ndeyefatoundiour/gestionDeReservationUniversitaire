<?php

declare(strict_types=1);

/**
 * Layout principal.
 *
 * Variables attendues :
 * @var string $title   Titre de la page
 * @var string $content Contenu HTML déjà généré par la vue appelante
 *
 * Cette vue ne contient aucune règle métier : elle affiche uniquement
 * les messages flash de session et le contenu qui lui est transmis.
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Réservation des salles universitaires') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="/" class="logo">Réservation des salles</a>
        <nav class="main-nav">
            <a href="/salles">Salles</a>
            <a href="/reservations">Réservations</a>
        </nav>
    </div>
</header>

<main class="container">
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success" role="alert">
            <?= e($_SESSION['flash_success']) ?>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-error" role="alert">
            <?= e($_SESSION['flash_error']) ?>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="container">
        <p>Université &mdash; Gestion des réservations de salles</p>
    </div>
</footer>

</body>
</html>
