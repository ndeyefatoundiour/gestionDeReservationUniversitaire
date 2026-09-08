<?php

declare(strict_types=1);

/**
 * Formulaire salle, utilisé pour la création ET la modification.
 *
 * Variables attendues :
 * @var \App\Model\Salle|null $salle  null en création, instance existante en modification
 * @var array                 $errors Erreurs de validation indexées par champ
 * @var array                 $old    Valeurs précédemment soumises (après erreur)
 */
$errors = $errors ?? [];
$old = $old ?? [];
$isEdit = isset($salle) && $salle !== null;

$title = $isEdit ? 'Modifier une salle' : 'Ajouter une salle';
$action = $isEdit ? '/salles/' . $salle->id . '/edit' : '/salles';

$types = [
    'cours' => 'Cours',
    'informatique' => 'Informatique',
    'laboratoire' => 'Laboratoire',
    'amphitheatre' => 'Amphithéâtre',
    'reunion' => 'Réunion',
];

$currentNom = $isEdit ? old($old, 'nom', $salle->nom) : old($old, 'nom');
$currentBatiment = $isEdit ? old($old, 'batiment', $salle->batiment) : old($old, 'batiment');
$currentCapacite = $isEdit ? old($old, 'capacite', (string) $salle->capacite) : old($old, 'capacite');
$currentType = $old['type'] ?? ($isEdit ? $salle->type : '');
$currentActive = array_key_exists('active', $old) ? (bool) $old['active'] : ($isEdit ? $salle->active : true);

ob_start();
?>
<div class="page-header">
    <h1><?= e($title) ?></h1>
</div>

<form method="post" action="<?= e($action) ?>" class="form" novalidate>

    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?= $currentNom ?>"
               class="<?= has_error($errors, 'nom') ? 'input-error' : '' ?>">
        <?= field_error($errors, 'nom') ?>
    </div>

    <div class="form-group">
        <label for="batiment">Bâtiment</label>
        <input type="text" id="batiment" name="batiment" value="<?= $currentBatiment ?>"
               class="<?= has_error($errors, 'batiment') ? 'input-error' : '' ?>">
        <?= field_error($errors, 'batiment') ?>
    </div>

    <div class="form-group">
        <label for="capacite">Capacité</label>
        <input type="number" id="capacite" name="capacite" min="1" max="1000" value="<?= $currentCapacite ?>"
               class="<?= has_error($errors, 'capacite') ? 'input-error' : '' ?>">
        <?= field_error($errors, 'capacite') ?>
    </div>

    <div class="form-group">
        <label for="type">Type</label>
        <select id="type" name="type" class="<?= has_error($errors, 'type') ? 'input-error' : '' ?>">
            <option value="">&mdash; Sélectionner &mdash;</option>
            <?php foreach ($types as $value => $label): ?>
                <option value="<?= e($value) ?>" <?= $currentType === $value ? 'selected' : '' ?>>
                    <?= e($label) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?= field_error($errors, 'type') ?>
    </div>

    <?php if ($isEdit): ?>
        <div class="form-group form-check">
            <label>
                <input type="checkbox" name="active" value="1" <?= $currentActive ? 'checked' : '' ?>>
                Salle active
            </label>
        </div>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="/salles" class="btn btn-link">Annuler</a>
    </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
