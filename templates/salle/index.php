<?php ob_start(); ?>

<div class="content-panel">
    <div class="toolbar">
        <h2>Liste des salles universitaires</h2>
        <a href="/salles/create" class="btn btn-primary"><span class="btn-icon">✦</span> Ajouter une salle</a>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Bâtiment</th>
                    <th>Capacité</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salles as $salle): ?>
                    <tr>
                        <td><strong><?= e($salle->nom); ?></strong></td>
                        <td><?= e($salle->batiment); ?></td>
                        <td><?= e($salle->capacite); ?> places</td>
                        <td><span class="badge"><?= e($salle->type); ?></span></td>
                        <td>
                            <span class="status <?= $salle->active ? 'active' : 'inactive'; ?>">
                                <?= $salle->active ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td>
                            <a class="link-muted" href="/salles/<?= e($salle->id); ?>"><span class="btn-icon">◌</span> Voir</a> |
                            <a class="link-muted" href="/salles/<?= e($salle->id); ?>/edit"><span class="btn-icon">✎</span> Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require dirname(__DIR__) . '/layout/base.php'; 
?>
