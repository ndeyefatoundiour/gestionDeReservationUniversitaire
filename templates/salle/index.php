<?php ob_start(); ?>

<h2>Liste des salles universitaires</h2>
<div class="actions">
    <a href="/salles/creer" class="btn btn-primary">➕ Ajouter une nouvelle salle</a>
</div>

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
                        <?= $salle->active ? 'Actives' : 'Inactives'; ?>
                    </span>
                </td>
                <td>
                    <a href="/salles/<?= e($salle->id); ?>">👁️ Voir</a> | 
                    <a href="/salles/<?= e($salle->id); ?>/modifier">✏️ Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean(); 
require dirname(__DIR__) . '/layout/base.php'; 
?>
