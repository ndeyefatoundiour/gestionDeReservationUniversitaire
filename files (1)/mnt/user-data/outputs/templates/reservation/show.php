<?php

declare(strict_types=1);

/**
 * Détail d'une réservation.
 *
 * Variables attendues :
 * @var \App\Model\Reservation $reservation
 */
$title = 'Réservation #' . $reservation->id;

ob_start();
?>
<div class="page-header">
    <h1>Réservation #<?= e($reservation->id) ?></h1>
</div>

<dl class="detail-list">
    <dt>Salle</dt>
    <dd><a href="/salles/<?= e($reservation->salle->id) ?>"><?= e($reservation->salle->nom) ?></a></dd>

    <dt>Responsable</dt>
    <dd><?= e($reservation->responsable) ?></dd>

    <dt>Email</dt>
    <dd><?= e($reservation->email) ?></dd>

    <dt>Motif</dt>
    <dd><?= e($reservation->motif) ?></dd>

    <dt>Début</dt>
    <dd><?= e($reservation->date_debut->format('d/m/Y H:i')) ?></dd>

    <dt>Fin</dt>
    <dd><?= e($reservation->date_fin->format('d/m/Y H:i')) ?></dd>

    <dt>Statut</dt>
    <dd>
        <span class="badge <?= $reservation->statut === 'confirmée' ? 'badge-success' : 'badge-muted' ?>">
            <?= e($reservation->statut) ?>
        </span>
    </dd>
</dl>

<?php if ($reservation->statut === 'confirmée'): ?>
    <form method="post" action="/reservations/<?= e($reservation->id) ?>/cancel"
          onsubmit="return confirm('Confirmer l\'annulation de cette réservation ?');">
        <button type="submit" class="btn btn-danger">Annuler la réservation</button>
    </form>
<?php endif; ?>

<p class="back-link"><a href="/reservations">&larr; Retour à la liste des réservations</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/base.php';
