<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use Illuminate\Database\Eloquent\Collection;

final class EloquentSalleRepository implements SalleRepositoryInterface
{
    public function listerTous(): Collection
    {
        return Salle::all();
    }

    public function trouverParId(int $id): ?Salle
    {
        return Salle::find($id);
    }

    public function enregistrer(CreerSalleDTO $dto): Salle
    {
        return Salle::create([
            'nom' => $dto->nom,
            'batiment' => $dto->batiment,
            'capacite' => $dto->capacite,
            'type' => $dto->type,
            'active' => $dto->active,
        ]);    
    }
 
}
