<?php ob_start(); ?>

<h2>Détails de la Réservation ##<?= e($reservation->id); ?></h2>

<div class="card">
    <p><strong>Salle réservée :</strong> <?= e($reservation->salle->nom); ?> (<?= e($reservation->salle->batiment); ?>)</p>
    <p><strong>Responsable :</strong> <?= e($reservation->responsable); ?></p>
    <p><strong>Email :</strong> <?= e($reservation->email); ?></p>
    <p><strong>Motif de la réservation :</strong> <?= e($reservation->motif); ?></p>
    <p><strong>Créneau horaire :</strong> Du <?= e($reservation->date_debut->format('d/m/Y à H:i')); ?> au <?= e($reservation->date_fin->format('d/m/Y à H:i')); ?></p>
    <p><strong>Statut actuel :</strong> 
        <span class="badge <?= $reservation->statut === 'confirmée' ? 'badge-success' : 'badge-danger'; ?>">
            <?= e($reservation->statut); ?>
        </span>
    </p>
</div>

<p class="actions-buttons">
    <a href="/reservations" class="btn">🔙 Retour à la liste</a>
    <a href="/reservations/<?= e($reservation->id); ?>/edit" class="btn btn-primary">✏️ Modifier</a>
    
    <?php if ($reservation->statut === 'confirmée'): ?>
        <form method="POST" action="/reservations/<?= e($reservation->id); ?>/annuler" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
            <button type="submit" class="btn btn-danger">❌ Annuler la réservation</button>
        </form>
    <?php endif; ?>
</p>

<?php 
$content = ob_get_clean(); 
require dirname(dirname(__DIR__)) . '/templates/layout/base.php'; 
?>
