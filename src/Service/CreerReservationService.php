<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use DateTimeImmutable;

final class CreerReservationService
{
    public function __construct(
        private readonly SalleRepositoryInterface $salleRepository,
        private readonly ReservationRepositoryInterface $reservationRepository
    ) {
    }

    /**
     * @throws SalleIndisponibleException
     */
    public function executer(CreerReservationDTO $dto): Reservation
    {
        // 1. Retrouver la salle
        $salle = $this->salleRepository->trouverParId($dto->salleId);
        if (null === $salle) {
            throw new SalleIndisponibleException("La salle demandée n'existe pas.");
        }

        // 2. Vérifier qu’elle est active
        if (!$salle->active) {
            throw new SalleIndisponibleException("La salle demandée est actuellement désactivée.");
        }

        // 3. Vérifier que le début précède la fin
        if ($dto->dateDebut >= $dto->dateFin) {
            throw new SalleIndisponibleException("La date de début doit strictement précéder la date de fin.");
        }

        // 4. Vérifier que la durée ne dépasse pas quatre heures (4 * 3600 secondes)
        $dureeEnSecondes = $dto->dateFin->getTimestamp() - $dto->dateDebut->getTimestamp();
        if ($dureeEnSecondes > (4 * 3600)) {
            throw new SalleIndisponibleException("La réservation ne peut pas excéder une durée de quatre heures.");
        }

        // 5. Vérifier que la date est future
        if ($dto->dateDebut <= new DateTimeImmutable()) {
            throw new SalleIndisponibleException("La réservation doit débuter dans le futur.");
        }

        // 6. Rechercher les chevauchements
        $conflit = $this->reservationRepository->rechercherConflit($dto->salleId, $dto->dateDebut, $dto->dateFin);
        if ($conflit) {
            throw new SalleIndisponibleException("La salle est déjà réservée ou occupée sur ce créneau horaire.");
        }

        // 7 & 8. Créer et enregistrer la réservation via le Repository
        return $this->reservationRepository->enregistrer($dto);
    }
}
