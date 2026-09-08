<?php

declare(strict_types=1);

namespace App\Exception;

final class SalleIntrouvableException extends \RuntimeException
{
    public static function pourId(int $id): self
    {
        return new self(sprintf('Aucune salle trouvée avec l\'identifiant %d.', $id));
    }
}
