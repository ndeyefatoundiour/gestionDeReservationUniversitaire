<?php

declare(strict_types=1);

/**
 * Détail d'une salle.
 *
 * Variables attendues :
 * @var \App\Model\Salle $salle
 * @var iterable         $reservations Réservations liées à cette salle (peut être vide)
 */
$title = 'Salle — ' . $salle->nom;
$reservations = $reservations ?? [];

ob_start();
?>
<div class="page-header">
    <h1><?= e($salle->nom) ?></h1>
    <a href="/salles/<?= e($salle->id) ?>/edit" class="btn btn-secondary">Modifier</a>
</div>

<dl class="detail-list">
    <dt>Bâtiment</dt>
    <dd><?= e($salle->batiment) ?></dd>

    <dt>Capacité</dt>
    <dd><?= e($salle->capacite) ?> personnes</dd>

    <dt>Type</dt>
    <dd><?= e($salle->type) ?></dd>

    <dt>Statut</dt>
    <dd>
        <?php if ($salle->active): ?>
            <span class="badge badge-success">Active</span>
        <?php else: ?>
            <span class="badge badge-muted">Inactive</span>
        <?php endif; ?>
    </dd>
</dl>

<h2>Réservations pour cette salle</h2>

<?php if (empty($reservations)): ?>
    <p class="empty-state">Aucune réservation enregistrée pour cette salle.</p>
<?php else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>Responsable</th>
            <th>Motif</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
            <th class="table-actions-col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= e($reservation->responsable) ?></td>
                <td><?= e($reservation->motif) ?></td>
                <td><?= e($reservation->date_debut->format('d/m/Y H:i')) ?></td>
                <td><?= e($reservation->date_fin->format('d/m/Y H:i')) ?></td>
                <td>
                    <span class="badge <?= $reservation->statut === 'confirmée' ? 'badge-success' : 'badge-muted' ?>">
                        <?= e($reservation->statut) ?>
                    </span>
                </td>
                <td class="table-actions">
                    <a href="/reservations/<?= e($reservation->id) ?>">Voir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p class="back-link"><a href="/salles">&larr; Retour à la liste des salles</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
