<?php

declare(strict_types=1);

namespace App\DTO;

use App\Exception\DonneesInvalidesException;

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
        $errors = [];
        $nom = is_string($data['nom'] ?? null) ? trim($data['nom']) : '';
        $batiment = is_string($data['batiment'] ?? null) ? trim($data['batiment']) : '';
        $capacite = filter_var($data['capacite'] ?? null, FILTER_VALIDATE_INT);
        $type = $data['type'] ?? null;

        if (strlen($nom) < 2 || strlen($nom) > 100) {
            $errors['nom'][] = 'Le nom doit contenir entre 2 et 100 caractères.';
        }
        if (strlen($batiment) < 2 || strlen($batiment) > 100) {
            $errors['batiment'][] = 'Le bâtiment doit contenir entre 2 et 100 caractères.';
        }
        if (false === $capacite || $capacite < 1 || $capacite > 1000) {
            $errors['capacite'][] = 'La capacité doit être un entier compris entre 1 et 1000.';
        }
        if (!is_string($type) || !in_array($type, \App\Model\Salle::TYPES, true)) {
            $errors['type'][] = 'Le type de salle est invalide.';
        }

        if ([] !== $errors) {
            throw new DonneesInvalidesException($errors);
        }

        return new self($nom, $batiment, $capacite, $type, isset($data['active']));
    }

    public static function builder(): CreerSalleDTOBuilder
    {
        return new CreerSalleDTOBuilder();
    }
}
