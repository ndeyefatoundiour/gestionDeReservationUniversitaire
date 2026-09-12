<?php ob_start(); ?>

<h2><?= $isEdit ? '✏️ Modifier la salle' : '➕ Ajouter une nouvelle salle'; ?></h2>

<form method="POST" action="<?= $isEdit ? '/salles/' . e($salle->id) . '/edit' : '/salles'; ?>" class="form">
    <div class="form-group <?= has_error($errors, 'nom') ? 'has-error' : ''; ?>">
        <label for="nom">Nom de la salle :</label>
        <input type="text" id="nom" name="nom" value="<?= old($old, 'nom', $salle->nom ?? ''); ?>" minlength="2" maxlength="100" required>
        <?= field_error($errors, 'nom'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'batiment') ? 'has-error' : ''; ?>">
        <label for="batiment">Bâtiment :</label>
        <input type="text" id="batiment" name="batiment" value="<?= old($old, 'batiment', $salle->batiment ?? ''); ?>" minlength="2" maxlength="100" required>
        <?= field_error($errors, 'batiment'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'capacite') ? 'has-error' : ''; ?>">
        <label for="capacite">Capacité maximale :</label>
        <input type="number" id="capacite" name="capacite" value="<?= old($old, 'capacite', (string)($salle->capacite ?? '')); ?>" min="1" max="1000" required>
        <?= field_error($errors, 'capacite'); ?>
    </div>

    <div class="form-group <?= has_error($errors, 'type') ? 'has-error' : ''; ?>">
        <label for="type">Type de salle :</label>
        <select id="type" name="type" required>
            <?php $currentType = $old['type'] ?? ($salle->type ?? ''); ?>
            <option value="" <?= '' === $currentType ? 'selected' : ''; ?>>-- Sélectionnez un type --</option>
            <?php foreach (\App\Model\Salle::TYPES as $typeOption): ?>
                <?php $selected = $currentType === $typeOption ? 'selected' : ''; ?>
                <option value="<?= e($typeOption); ?>" <?= $selected; ?>><?= e($typeOption); ?></option>
            <?php endforeach; ?>
        </select>
        <?= field_error($errors, 'type'); ?>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="active" value="1" <?= old($old, 'active', (string)($salle->active ?? true)) ? 'checked' : ''; ?>>
            Salle active (autoriser les réservations)
        </label>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-success">Enregistrer la salle</button>
        <a href="/salles" class="btn">Annuler</a>
    </div>
</form>

<?php 
$content = ob_get_clean(); 
require dirname(__DIR__) . '/layout/base.php'; 
?>
