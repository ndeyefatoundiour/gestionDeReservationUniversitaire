<?php

declare(strict_types=1);

/**
 * Formulaire de création d'une réservation.
 *
 * Variables attendues :
 * @var iterable $salles Salles disponibles (idéalement uniquement les salles actives)
 * @var array    $errors Erreurs de validation indexées par champ
 * @var array    $old    Valeurs précédemment soumises (après erreur)
 */
$title = 'Nouvelle réservation';
$errors = $errors ?? [];
$old = $old ?? [];

ob_start();
?>
<div class="page-header">
    <h1>Nouvelle réservation</h1>
</div>

<form method="post" action="/reservations" class="form" novalidate>

    <div class="form-group">
        <label for="salle_id">Salle</label>
        <select id="salle_id" name="salle_id" class="<?= has_error($errors, 'salle_id') ? 'input-error' : '' ?>">
            <option value="">&mdash; Sélectionner une salle &mdash;</option>
            <?php foreach ($salles as $salle): ?>
                <option value="<?= e($salle->id) ?>"
                    <?= (string) ($old['salle_id'] ?? '') === (string) $salle->id ? 'selected' : '' ?>>
                    <?= e($salle->nom) ?> (<?= e($salle->capacite) ?> places)
                </option>
            <?php endforeach; ?>
        </select>
        <?= field_error($errors, 'salle_id') ?>
    </div>

    <div class="form-group">
        <label for="responsable">Responsable</label>
        <input type="text" id="responsable" name="responsable" value="<?= old($old, 'responsable') ?>"
               class="<?= has_error($errors, 'responsable') ? 'input-error' : '' ?>">
        <?= field_error($errors, 'responsable') ?>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= old($old, 'email') ?>"
               class="<?= has_error($errors, 'email') ? 'input-error' : '' ?>">
        <?= field_error($errors, 'email') ?>
    </div>

    <div class="form-group">
        <label for="motif">Motif</label>
        <textarea id="motif" name="motif" rows="3"
                  class="<?= has_error($errors, 'motif') ? 'input-error' : '' ?>"><?= old($old, 'motif') ?></textarea>
        <?= field_error($errors, 'motif') ?>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="date_debut">Date et heure de début</label>
            <input type="datetime-local" id="date_debut" name="date_debut" value="<?= old($old, 'date_debut') ?>"
                   class="<?= has_error($errors, 'date_debut') ? 'input-error' : '' ?>">
            <?= field_error($errors, 'date_debut') ?>
        </div>

        <div class="form-group">
            <label for="date_fin">Date et heure de fin</label>
            <input type="datetime-local" id="date_fin" name="date_fin" value="<?= old($old, 'date_fin') ?>"
                   class="<?= has_error($errors, 'date_fin') ? 'input-error' : '' ?>">
            <?= field_error($errors, 'date_fin') ?>
        </div>
    </div>

    <p class="form-hint">Durée maximale : 4 heures. La réservation doit débuter dans le futur.</p>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Réserver</button>
        <a href="/reservations" class="btn btn-link">Annuler</a>
    </div>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
