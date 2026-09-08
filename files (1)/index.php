<?php

declare(strict_types=1);

/**
 * Liste des salles.
 *
 * Variables attendues :
 * @var iterable $salles Collection d'objets Salle (id, nom, batiment, capacite, type, active)
 */
$title = 'Liste des salles';

ob_start();
?>
<div class="page-header">
    <h1>Salles</h1>
    <a href="/salles/create" class="btn btn-primary">Ajouter une salle</a>
</div>

<?php if (empty($salles)): ?>
    <p class="empty-state">Aucune salle enregistrée pour le moment.</p>
<?php else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Bâtiment</th>
            <th>Capacité</th>
            <th>Type</th>
            <th>Statut</th>
            <th class="table-actions-col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($salles as $salle): ?>
            <tr>
                <td><?= e($salle->nom) ?></td>
                <td><?= e($salle->batiment) ?></td>
                <td><?= e($salle->capacite) ?></td>
                <td><?= e($salle->type) ?></td>
                <td>
                    <?php if ($salle->active): ?>
                        <span class="badge badge-success">Active</span>
                    <?php else: ?>
                        <span class="badge badge-muted">Inactive</span>
                    <?php endif; ?>
                </td>
                <td class="table-actions">
                    <a href="/salles/<?= e($salle->id) ?>">Voir</a>
                    <a href="/salles/<?= e($salle->id) ?>/edit">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
