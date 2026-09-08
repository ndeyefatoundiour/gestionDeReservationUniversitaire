<?php ob_start(); ?>
<div class="error-container">
    <h2>🛡️ Erreur 405 - Méthode Non Autorisée</h2>
    <p>Le protocole de cette requête HTTP n'est pas autorisé pour cette URL.</p>
</div>
<?php 
$content = ob_get_clean(); 
require dirname(__DIR__) . '/layout/base.php'; 
?>
