<?php ob_start(); ?>

<h2>Gestion des Réservations</h2>

<div class="filter-box">
    <form method="GET" action="/reservations">
        <label for="salle_filter">Filtrer par salle :</label>
        <select id="salle_filter" name="salle_id" onchange="this.form.submit()">
            <option value="">-- Toutes les salles --</option>
            <?php foreach ($salles as $salleOption): ?>
                <option value="<?= e($salleOption->id); ?>" <?= $selectedSalleId === $salleOption->id ? 'selected' : ''; ?>>
                    <?= e($salleOption->nom); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <a href="/reservations/creer" class="btn btn-primary">📅 Nouvelle Réservation</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Salle</th>
            <th>Responsable</th>
            <th>Motif</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $res): ?>
            <tr>
                <td><strong><?= e($res->salle->nom); ?></strong></td>
                <td><?= e($res->responsable); ?> (<a href="mailto:<?= e($res->email); ?>"><?= e($res->email); ?></a>)</td>
                <td><?= e($res->motif); ?></td>
                <td><?= e($res->date_debut->format('d/m/Y H:i')); ?></td>
                <td><?= e($res->date_fin->format('d/m/Y H:i')); ?></td>
                <td>
                    <span class="status-badge <?= $res->statut === 'confirmée' ? 'confirmed' : 'cancelled'; ?>">
                        <?= e($res->statut); ?>
                    </span>
                </td>
                <td>
                    <a href="/reservations/<?= e($res->id); ?>">👁️ Voir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
$content = ob_get_clean(); 
require dirname(dirname(__DIR__)) . '/templates/layout/base.php'; 
?>
