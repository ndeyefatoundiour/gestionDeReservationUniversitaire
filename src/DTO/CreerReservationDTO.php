<?php

declare(strict_types=1);

namespace App\DTO;

use App\Exception\DonneesInvalidesException;
use App\Validation\ReservationValidator;

final class CreerReservationDTO
{
    public function __construct(
        public readonly int $salleId,
        public readonly string $responsable,
        public readonly string $email,
        public readonly string $motif,
        public readonly \DateTimeImmutable $dateDebut,
        public readonly \DateTimeImmutable $dateFin
    ) {
    }

    public static function depuisDonneesValidees(array $data): self
    {
        $result = (new ReservationValidator())->validate($data);

        if (! $result->isValid()) {
            throw new DonneesInvalidesException($result->errors());
        }

        $validated = $result->data();

        return new self(
            salleId: $validated['salle_id'],
            responsable: $validated['responsable'],
            email: $validated['email'],
            motif: $validated['motif'],
            dateDebut: $validated['date_debut'],
            dateFin: $validated['date_fin'],
        );
    }

    public static function builder(): CreerReservationDTOBuilder
    {
        return new CreerReservationDTOBuilder();
    }
}

