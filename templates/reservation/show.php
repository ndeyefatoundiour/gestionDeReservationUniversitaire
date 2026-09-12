<?php ob_start(); ?>

<div class="content-panel detail-card">
    <div class="toolbar">
        <h2><span class="btn-icon">◫</span> Réservation #<?= e($reservation->id); ?></h2>
        <span class="status-badge <?= $reservation->statut === 'confirmée' ? 'confirmed' : 'cancelled'; ?>"><?= e($reservation->statut); ?></span>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <span class="label">Salle réservée</span>
            <strong><?= e($reservation->salle->nom); ?></strong>
            <small><?= e($reservation->salle->batiment); ?></small>
        </div>

        <div class="detail-item">
            <span class="label">Responsable</span>
            <strong><?= e($reservation->responsable); ?></strong>
            <small><?= e($reservation->email); ?></small>
        </div>

        <div class="detail-item full">
            <span class="label">Motif</span>
            <strong><?= e($reservation->motif); ?></strong>
        </div>

        <div class="detail-item full">
            <span class="label">Créneau</span>
            <strong>Du <?= e($reservation->date_debut->format('d/m/Y à H:i')); ?> au <?= e($reservation->date_fin->format('d/m/Y à H:i')); ?></strong>
        </div>
    </div>

    <div class="form-actions">
        <a href="/reservations" class="btn"><span class="btn-icon">←</span> Retour</a>
        <a href="/reservations/<?= e($reservation->id); ?>/edit" class="btn btn-primary"><span class="btn-icon">✎</span> Modifier</a>

        <?php if ($reservation->statut === 'confirmée'): ?>
            <form method="POST" action="/reservations/<?= e($reservation->id); ?>/annuler" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                <button type="submit" class="btn btn-danger"><span class="btn-icon">✕</span> Annuler</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require dirname(dirname(__DIR__)) . '/templates/layout/base.php'; 
?>
