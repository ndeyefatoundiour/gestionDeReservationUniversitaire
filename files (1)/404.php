<?php

declare(strict_types=1);

/**
 * Page 404 — route inconnue.
 * Le code de statut HTTP doit idéalement déjà être fixé par le routeur/Application
 * avant l'inclusion de cette vue ; il est refixé ici par sécurité.
 */
http_response_code(404);

$title = 'Page introuvable';

ob_start();
?>
<div class="error-page">
    <p class="error-code">404</p>
    <h1>Page introuvable</h1>
    <p>La page que vous recherchez n'existe pas ou a été déplacée.</p>
    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
