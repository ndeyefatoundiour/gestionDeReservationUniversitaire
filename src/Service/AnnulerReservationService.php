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

    /**
     * @throws ReservationIntrouvableException
     */
    public function executer(int $reservationId): void
    {
        $reservation = $this->reservationRepository->trouverParId($reservationId);
        
        if (null === $reservation) {
            throw new ReservationIntrouvableException("La réservation à annuler est introuvable.");
        }

        $this->reservationRepository->annuler($reservationId);
    }
}
