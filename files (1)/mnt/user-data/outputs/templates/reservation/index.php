<?php

declare(strict_types=1);

/**
 * Liste des réservations, avec filtre optionnel par salle.
 *
 * Variables attendues :
 * @var iterable $reservations
 * @var iterable $salles           Toutes les salles, pour le filtre
 * @var int|null $selectedSalleId  Salle actuellement sélectionnée dans le filtre
 */
$title = 'Réservations';
$selectedSalleId = $selectedSalleId ?? null;

ob_start();
?>
<div class="page-header">
    <h1>Réservations</h1>
    <a href="/reservations/create" class="btn btn-primary">Nouvelle réservation</a>
</div>

<form method="get" action="/reservations" class="filter-form">
    <label for="salle_id">Filtrer par salle</label>
    <select id="salle_id" name="salle_id" onchange="this.form.submit()">
        <option value="">Toutes les salles</option>
        <?php foreach ($salles as $salle): ?>
            <option value="<?= e($salle->id) ?>" <?= $selectedSalleId === $salle->id ? 'selected' : '' ?>>
                <?= e($salle->nom) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <noscript><button type="submit" class="btn btn-secondary">Filtrer</button></noscript>
</form>

<?php if (empty($reservations)): ?>
    <p class="empty-state">Aucune réservation trouvée.</p>
<?php else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>Salle</th>
            <th>Responsable</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
            <th class="table-actions-col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= e($reservation->salle->nom ?? '—') ?></td>
                <td><?= e($reservation->responsable) ?></td>
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
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
