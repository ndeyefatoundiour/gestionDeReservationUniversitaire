<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ReservationIntrouvableException;
use App\Repository\ReservationRepositoryInterface;

final class AnnulerReservationService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepository
    ) {
    }

   
    public function annuler(int $id): void
    {
        $reservation = $this->reservationRepository->trouver($id);
        
        if (null === $reservation) {
            throw ReservationIntrouvableException::pourId($id);
        }

        $this->reservationRepository->annuler($id);
    }
}
