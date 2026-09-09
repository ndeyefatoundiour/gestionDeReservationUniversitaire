<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

final class CreerSalleService
{
    public function __construct(private readonly SalleRepositoryInterface $salles)
    {
    }

    public function creer(CreerSalleDTO $dto): Salle
    {
        return $this->salles->enregistrer($dto);
    }
}
