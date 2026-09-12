<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Salles et Réservations Universitaires</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header class="topbar">
        <div class="container nav-wrap">
            <div class="brand">
                <span class="brand-mark">U</span>
                <span>Université</span>
            </div>
            <nav class="main-nav">
                <a href="/salles"><span class="nav-icon">▣</span> Salles</a>
                <a href="/reservations"><span class="nav-icon">◫</span> Réservations</a>
            </nav>
        </div>
    </header>

    <main class="container page-shell">
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert-success">
                <?= htmlspecialchars((string) $_SESSION['flash_success'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($content)) { echo $content; } ?>
    </main>
</body>
</html>
