<?php ob_start(); ?>

<h2>Détails de la salle : <?= e($salle->nom); ?></h2>

<div class="card">
    <p><strong>Bâtiment :</strong> <?= e($salle->batiment); ?></p>
    <p><strong>Capacité maximale :</strong> <?= e($salle->capacite); ?> places</p>
    <p><strong>Type de salle :</strong> <?= e($salle->type); ?></p>
    <p><strong>Statut de disponibilité :</strong> <?= $salle->active ? 'Disponible à la réservation' : 'Indisponible'; ?></p>
</div>

<p>
    <a href="/salles" class="btn">🔙 Retour à la liste</a>
    <a href="/salles/<?= e($salle->id); ?>/edit" class="btn btn-primary">Modifier cette salle</a>
</p>

<?php 
$content = ob_get_clean(); 
require dirname(__DIR__) . '/layout/base.php'; 
?>
