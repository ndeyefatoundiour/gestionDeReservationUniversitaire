<?php ob_start(); ?>

<h2>📅 Réserver une salle universitaire</h2>

<form method="POST" action="/reservations" class="form">
    <div class="form-group <?= has_error($errors, 'salle_id') ? 'has-error' : ''; ?>">
        <label for="salle_id">Sélectionnez la salle :</label>
        <select id="salle_id" name="salle_id">
            <?php foreach ($salles as $salle): ?>
                <option value="<?= e($salle->id); ?>" <?= old($old, 'salle_id') == $salle->id ? 'selected' : ''; ?>>
                    <?= e($salle->nom); ?> (<?= e($salle->batiment); ?>) - <?= e($salle->capacite); ?> pl
                </option>
            <?php endforeach; ?>
        </select>
        <?= field_error($errors, 'salle_id'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'responsable') ? 'has-error' : ''; ?>">
        <label for="responsable">Nom du responsable :</label>
        <input type="text" id="responsable" name="responsable" value="<?= old($old, 'responsable'); ?>" placeholder="Ex: M. Diop">
        <?= field_error($errors, 'responsable'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'email') ? 'has-error' : ''; ?>">
        <label for="email">Adresse électronique :</label>
        <input type="email" id="email" name="email" value="<?= old($old, 'email'); ?>" placeholder="responsable@univ.sn">
        <?= field_error($errors, 'email'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'motif') ? 'has-error' : ''; ?>">
        <label for="motif">Motif de la réservation :</label>
        <input type="text" id="motif" name="motif" value="<?= old($old, 'motif'); ?>" placeholder="Ex: Cours d'Algorithmique L1">
        <?= field_error($errors, 'motif'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'date_debut') ? 'has-error' : ''; ?>">
        <label for="date_debut">Date et heure de début :</label>
        <input type="text" id="date_debut" name="date_debut" value="<?= old($old, 'date_debut'); ?>" placeholder="AAAA-MM-JJ HH:MM:SS">
        <?= field_error($errors, 'date_debut'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'date_fin') ? 'has-error' : ''; ?>">
        <label for="date_fin">Date et heure de fin :</label>
        <input type="text" id="date_fin" name="date_fin" value="<?= old($old, 'date_fin'); ?>" placeholder="AAAA-MM-JJ HH:MM:SS">
        <?= field_error($errors, 'date_fin'); ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-success">Confirmer la réservation</button>
        <a href="/reservations" class="btn">Annuler</a>
    </div>
</form>

<?php 
$content = ob_get_clean(); 
require dirname(dirname(__DIR__)) . '/templates/layout/base.php'; 
?>
