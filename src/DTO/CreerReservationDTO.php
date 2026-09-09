<?php

declare(strict_types=1);

namespace App\DTO;

use App\Exception\DonneesInvalidesException;

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
        $errors = [];
        $salleId = filter_var($data['salle_id'] ?? null, FILTER_VALIDATE_INT);
        $responsable = is_string($data['responsable'] ?? null) ? trim($data['responsable']) : '';
        $email = is_string($data['email'] ?? null) ? trim($data['email']) : '';
        $motif = is_string($data['motif'] ?? null) ? trim($data['motif']) : '';

        if (false === $salleId || $salleId < 1) {
            $errors['salle_id'][] = 'La salle sélectionnée est invalide.';
        }
        if (mb_strlen($responsable) < 2 || mb_strlen($responsable) > 120) {
            $errors['responsable'][] = 'Le nom du responsable doit contenir entre 2 et 120 caractères.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = "L'adresse électronique est invalide.";
        }
        if (mb_strlen($motif) < 5 || mb_strlen($motif) > 255) {
            $errors['motif'][] = 'Le motif doit contenir entre 5 et 255 caractères.';
        }

        $dateDebut = self::convertirDate($data['date_debut'] ?? null, 'date_debut', $errors);
        $dateFin = self::convertirDate($data['date_fin'] ?? null, 'date_fin', $errors);

        if ([] !== $errors) {
            throw new DonneesInvalidesException($errors);
        }

        return new self($salleId, $responsable, $email, $motif, $dateDebut, $dateFin);
    }

    private static function convertirDate(mixed $value, string $field, array &$errors): ?\DateTimeImmutable
    {
        if (!is_string($value) || '' === trim($value)) {
            $errors[$field][] = 'La date est obligatoire et doit être valide.';
            return null;
        }

        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception) {
            $errors[$field][] = 'La date est invalide.';
            return null;
        }
    }

    public static function builder(): CreerReservationDTOBuilder
    {
        return new CreerReservationDTOBuilder();
    }
}

