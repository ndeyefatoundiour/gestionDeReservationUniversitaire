<?php ob_start(); ?>
<div class="error-container">
    <h2>🔍 Erreur 404 - Page Introuvable</h2>
    <p>La ressource demandée n'existe pas ou a été déplacée.</p>
    <a href="/salles" class="btn btn-primary">Retourner à l'accueil</a>
</div>
<?php 
$content = ob_get_clean(); 
require dirname(__DIR__) . '/layout/base.php'; 
?>
