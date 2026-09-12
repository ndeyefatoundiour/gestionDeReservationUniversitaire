<?php

declare(strict_types=1);

namespace App\DTO;

use App\Exception\DonneesInvalidesException;
use App\Validation\SalleValidator;

final class CreerSalleDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly string $batiment,
        public readonly int $capacite,
        public readonly string $type,
        public readonly bool $active
    ) {
    }

    public static function depuisDonnees(array $data): self
    {
        $result = (new SalleValidator())->validate($data);

        if (! $result->isValid()) {
            throw new DonneesInvalidesException($result->errors());
        }

        $validated = $result->data();

        return new self(
            nom: $validated['nom'],
            batiment: $validated['batiment'],
            capacite: $validated['capacite'],
            type: $validated['type'],
            active: $validated['active'],
        );
    }

    public static function builder(): CreerSalleDTOBuilder
    {
        return new CreerSalleDTOBuilder();
    }
}
