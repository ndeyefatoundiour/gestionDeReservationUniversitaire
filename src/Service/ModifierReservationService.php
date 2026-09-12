<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\PeriodeInvalideException;
use App\Exception\SalleIndisponibleException;
use App\Exception\SalleIntrouvableException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;

final class ModifierReservationService
{
    public function __construct(
        private readonly SalleRepositoryInterface $salleRepository,
        private readonly ReservationRepositoryInterface $reservationRepository,
    ) {
    }

    public function modifier(Reservation $reservation, CreerReservationDTO $dto): Reservation
    {
        $salle = $this->salleRepository->trouverParId($dto->salleId);
        if (null === $salle) {
            throw SalleIntrouvableException::pourId($dto->salleId);
        }

        if (! $salle->active) {
            throw SalleIndisponibleException::inactive();
        }

        if ($dto->dateDebut >= $dto->dateFin) {
            throw PeriodeInvalideException::finAvantDebut();
        }

        $dureeEnSecondes = $dto->dateFin->getTimestamp() - $dto->dateDebut->getTimestamp();
        if ($dureeEnSecondes > (4 * 3600)) {
            throw PeriodeInvalideException::dureeExcessive();
        }

        if ($dto->dateDebut <= new \DateTimeImmutable()) {
            throw PeriodeInvalideException::dateDansLePasse();
        }

        $conflit = $this->reservationRepository->rechercherConflit(
            $dto->salleId,
            $dto->dateDebut,
            $dto->dateFin,
        );

        $memePeriode = $reservation->salle_id === $dto->salleId
            && $reservation->date_debut->format('Y-m-d H:i:s') === $dto->dateDebut->format('Y-m-d H:i:s')
            && $reservation->date_fin->format('Y-m-d H:i:s') === $dto->dateFin->format('Y-m-d H:i:s');

        if ($conflit && ! $memePeriode) {
            throw SalleIndisponibleException::conflitHoraire();
        }

        return $this->reservationRepository->modifier($reservation, $dto);
    }
}
