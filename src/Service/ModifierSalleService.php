<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;

final class ModifierSalleService
{
    public function modifier(Salle $salle, CreerSalleDTO $dto): Salle
    {
        $salle->update([
            'nom' => $dto->nom,
            'batiment' => $dto->batiment,
            'capacite' => $dto->capacite,
            'type' => $dto->type,
            'active' => $dto->active,
        ]);

        return $salle->refresh();
    }
}
