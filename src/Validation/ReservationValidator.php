<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;


final class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $salleId = $data['salle_id'] ?? null;
        if (!v::intVal()->positive()->validate($salleId)) {
            $errors['salle_id'][] = 'La salle sélectionnée est invalide.';
        }

        $responsable = is_string($data['responsable'] ?? null) ? trim($data['responsable']) : null;
        if (!v::stringType()->length(2, 120)->validate($responsable)) {
            $errors['responsable'][] = 'Le nom du responsable doit contenir entre 2 et 120 caractères.';
        }

        $email = is_string($data['email'] ?? null) ? trim($data['email']) : null;
        if (!v::email()->validate($email)) {
            $errors['email'][] = "L'adresse électronique est invalide.";
        }

        $motif = is_string($data['motif'] ?? null) ? trim($data['motif']) : null;
        if (!v::stringType()->length(5, 255)->validate($motif)) {
            $errors['motif'][] = 'Le motif doit contenir entre 5 et 255 caractères.';
        }

        $dateDebut = $this->parseDate($data['date_debut'] ?? null);
        if (null === $dateDebut) {
            $errors['date_debut'][] = 'La date de début est invalide.';
        }

        $dateFin = $this->parseDate($data['date_fin'] ?? null);
        if (null === $dateFin) {
            $errors['date_fin'][] = 'La date de fin est invalide.';
        }

        if ([] !== $errors) {
            return ValidationResult::failure($errors);
        }

        return ValidationResult::success([
            'salle_id' => (int) $salleId,
            'responsable' => $responsable,
            'email' => $email,
            'motif' => $motif,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ]);
    }

    private function parseDate(mixed $value): ?\DateTimeImmutable
    {
        if (!is_string($value) || '' === trim($value)) {
            return null;
        }

        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception) {
            return null;
        }
    }
}
