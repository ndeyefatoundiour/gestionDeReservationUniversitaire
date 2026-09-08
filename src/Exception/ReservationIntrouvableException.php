<?php

declare(strict_types=1);

namespace App\Exception;

final class ReservationIntrouvableException extends \RuntimeException
{
    public static function pourId(int $id): self
    {
        return new self(sprintf('Aucune réservation trouvée avec l\'identifiant %d.', $id));
    }
}
