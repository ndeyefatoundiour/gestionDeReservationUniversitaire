<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;
use Illuminate\Database\Eloquent\Collection;

final class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function listerTous(): Collection
    {
        return Reservation::with('salle')->get();
    }

    public function trouverParId(int $id): ?Reservation
    {
        return Reservation::with('salle')->find($id);
    }

    public function enregistrer(CreerReservationDTO $dto): Reservation
    {
        return Reservation::create([
            'salle_id' => $dto->salleId,
            'responsable' => $dto->responsable,
            'email' => $dto->email,
            'motif' => $dto->motif,
            'date_debut' => $dto->dateDebut->format('Y-m-d H:i:s'),
            'date_fin' => $dto->dateFin->format('Y-m-d H:i:s'),
            'statut' => 'confirmée',
        ]);
    }

    public function modifier(Reservation $reservation, CreerReservationDTO $dto): Reservation
    {
        $reservation->update([
            'salle_id' => $dto->salleId,
            'responsable' => $dto->responsable,
            'email' => $dto->email,
            'motif' => $dto->motif,
            'date_debut' => $dto->dateDebut->format('Y-m-d H:i:s'),
            'date_fin' => $dto->dateFin->format('Y-m-d H:i:s'),
        ]);

        return $reservation->fresh();
    }

    public function annuler(int $id): bool
    {
        $reservation = Reservation::find($id);
        if (null === $reservation) {
            return false;
        }
        
        return $reservation->update(['statut' => 'annulée']);
    }

    public function rechercherConflit(int $salleId, \DateTimeImmutable $debut, \DateTimeImmutable $fin): bool
    {
        return Reservation::where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $fin->format('Y-m-d H:i:s'))
            ->where('date_fin', '>', $debut->format('Y-m-d H:i:s'))
            ->exists();
    }
}
