<?php

declare(strict_types=1);

/**
 * Page 405 — méthode HTTP non autorisée pour cette route.
 *
 * Variables attendues :
 * @var array $allowedMethods Méthodes HTTP acceptées par cette route (ex: ['GET', 'POST'])
 */
$allowedMethods = $allowedMethods ?? [];

http_response_code(405);
if (!empty($allowedMethods)) {
    header('Allow: ' . implode(', ', $allowedMethods));
}

$title = 'Méthode non autorisée';

ob_start();
?>
<div class="error-page">
    <p class="error-code">405</p>
    <h1>Méthode non autorisée</h1>
    <p>La méthode HTTP utilisée n'est pas autorisée pour cette ressource.</p>
    <?php if (!empty($allowedMethods)): ?>
        <p>Méthodes autorisées : <strong><?= e(implode(', ', $allowedMethods)) ?></strong></p>
    <?php endif; ?>
    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
