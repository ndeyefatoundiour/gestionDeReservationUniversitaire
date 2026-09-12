<?php
$isEdit = $isEdit ?? false;
$reservation = $reservation ?? null;
ob_start();
?>

<div class="content-panel">
    <div class="toolbar">
        <h2><?= $isEdit ? '✎ Modifier la réservation' : '◫ Réserver une salle universitaire'; ?></h2>
        <a href="/reservations" class="btn"><span class="btn-icon">←</span> Retour</a>
    </div>

    <form method="POST" action="<?= $isEdit ? '/reservations/' . e($reservation->id) . '/edit' : '/reservations'; ?>" class="form">
        <div class="form-grid">
            <div class="form-group <?= has_error($errors, 'salle_id') ? 'has-error' : ''; ?>">
                <label for="salle_id">Sélectionnez la salle :</label>
                <select id="salle_id" name="salle_id">
                    <?php $selectedSalleId = $old['salle_id'] ?? ($reservation->salle_id ?? ''); ?>
                    <option value="" <?= '' === (string) $selectedSalleId ? 'selected' : ''; ?>>-- Sélectionnez une salle --</option>
                    <?php foreach ($salles as $salle): ?>
                        <option value="<?= e($salle->id); ?>" <?= (string) $selectedSalleId === (string) $salle->id ? 'selected' : ''; ?>>
                            <?= e($salle->nom); ?> (<?= e($salle->batiment); ?>) - <?= e($salle->capacite); ?> places
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= field_error($errors, 'salle_id'); ?>
            </div>

            <div class="form-group <?= has_error($errors, 'responsable') ? 'has-error' : ''; ?>">
                <label for="responsable">Nom du responsable :</label>
                <input type="text" id="responsable" name="responsable" value="<?= old($old, 'responsable', $reservation->responsable ?? ''); ?>" placeholder="Ex: M. Diop" minlength="2" maxlength="120" required>
                <?= field_error($errors, 'responsable'); ?>
            </div>

            <div class="form-group <?= has_error($errors, 'email') ? 'has-error' : ''; ?>">
                <label for="email">Adresse électronique :</label>
                <input type="email" id="email" name="email" value="<?= old($old, 'email', $reservation->email ?? ''); ?>" placeholder="responsable@univ.sn" required>
                <?= field_error($errors, 'email'); ?>
            </div>

            <div class="form-group <?= has_error($errors, 'motif') ? 'has-error' : ''; ?>">
                <label for="motif">Motif de la réservation :</label>
                <input type="text" id="motif" name="motif" value="<?= old($old, 'motif', $reservation->motif ?? ''); ?>" placeholder="Ex: Cours d'Algorithmique L1" minlength="5" maxlength="255" required>
                <?= field_error($errors, 'motif'); ?>
            </div>

            <div class="form-group <?= has_error($errors, 'date_debut') ? 'has-error' : ''; ?>">
                <label for="date_debut">Date et heure de début :</label>
                <input type="datetime-local" id="date_debut" name="date_debut" value="<?= old($old, 'date_debut', $reservation?->date_debut?->format('Y-m-d\TH:i') ?? ''); ?>" step="60" required>
                <?= field_error($errors, 'date_debut'); ?>
            </div>

            <div class="form-group <?= has_error($errors, 'date_fin') ? 'has-error' : ''; ?>">
                <label for="date_fin">Date et heure de fin :</label>
                <input type="datetime-local" id="date_fin" name="date_fin" value="<?= old($old, 'date_fin', $reservation?->date_fin?->format('Y-m-d\TH:i') ?? ''); ?>" step="60" required>
                <?= field_error($errors, 'date_fin'); ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success"><span class="btn-icon">✓</span><?= $isEdit ? 'Enregistrer les modifications' : 'Confirmer la réservation'; ?></button>
            <a href="/reservations" class="btn"><span class="btn-icon">✕</span> Annuler</a>
        </div>
    </form>
</div>

<?php 
$content = ob_get_clean(); 
require dirname(dirname(__DIR__)) . '/templates/layout/base.php'; 
?>
