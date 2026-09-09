<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Salles et Réservations Universitaires</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; background: #f4f6f9; }
        nav { background: #003366; padding: 15px; color: white; }
        nav a { color: white; text-decoration: none; margin-right: 15px; font-weight: bold; }
        main { max-width: 1100px; margin: 30px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .btn { display: inline-block; padding: 8px 15px; text-decoration: none; border-radius: 4px; background: #003366; color: white; font-weight: bold; }
    </style>
</head>
<body>

    <nav>
        <a href="/salles">🏛️ Salles</a>
        <a href="/reservations">📅 Réservations</a>
    </nav>

    <main>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="background: #dff0d8; color: #3c763d; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                <?= htmlspecialchars((string) $_SESSION['flash_success'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($content)) { echo $content; } ?>
    </main>

</body>
</html>
