<?php ob_start(); ?>

<div class="content-panel detail-card">
    <div class="toolbar">
        <h2><span class="btn-icon">▣</span> <?= e($salle->nom); ?></h2>
        <span class="status <?= $salle->active ? 'active' : 'inactive'; ?>"><?= $salle->active ? 'Disponible' : 'Indisponible'; ?></span>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <span class="label">Bâtiment</span>
            <strong><?= e($salle->batiment); ?></strong>
        </div>

        <div class="detail-item">
            <span class="label">Capacité</span>
            <strong><?= e($salle->capacite); ?> places</strong>
        </div>

        <div class="detail-item full">
            <span class="label">Type</span>
            <strong><?= e($salle->type); ?></strong>
        </div>
    </div>

    <div class="form-actions">
        <a href="/salles" class="btn"><span class="btn-icon">←</span> Retour</a>
        <a href="/salles/<?= e($salle->id); ?>/edit" class="btn btn-primary"><span class="btn-icon">✎</span> Modifier</a>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require dirname(__DIR__) . '/layout/base.php'; 
?>
