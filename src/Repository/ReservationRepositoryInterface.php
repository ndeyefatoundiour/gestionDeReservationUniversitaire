<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;
use Illuminate\Database\Eloquent\Collection;

interface ReservationRepositoryInterface
{
    
    public function listerTous(): Collection;

    public function trouverParId(int $id): ?Reservation;

    public function enregistrer(CreerReservationDTO $dto): Reservation;

    public function annuler(int $id): bool;

    public function rechercherConflit(int $salleId, \DateTimeImmutable $debut, \DateTimeImmutable $fin): bool;
}
