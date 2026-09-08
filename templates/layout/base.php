<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Salles et Réservations Universitaires</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/salles">🏛️ Gestion des Salles</a> | 
            <a href="/reservations">📅 Gestion des Réservations</a>
        </nav>
    </header>

    <main>
        <!-- Affichage d'un message flash de succès si présent en session -->
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert alert-success">
                <?= e($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <!-- Injection dynamique du contenu spécifique de chaque vue -->
        <?= $content; ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> - Application de Gestion Universitaire</p>
    </footer>
</body>
</html>
