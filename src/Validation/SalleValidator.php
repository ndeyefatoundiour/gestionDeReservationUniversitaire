<?php

declare(strict_types=1);

namespace App\Validation;

use App\Model\Salle;
use Respect\Validation\Validator as v;


final class SalleValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $nom = is_string($data['nom'] ?? null) ? trim($data['nom']) : null;
        if (!v::stringType()->length(2, 100)->validate($nom)) {
            $errors['nom'][] = 'Le nom doit contenir entre 2 et 100 caractères.';
        }

        $batiment = is_string($data['batiment'] ?? null) ? trim($data['batiment']) : null;
        if (!v::stringType()->length(2, 100)->validate($batiment)) {
            $errors['batiment'][] = 'Le bâtiment doit contenir entre 2 et 100 caractères.';
        }

        $capaciteBrute = $data['capacite'] ?? null;
        if (!v::intVal()->between(1, 1000)->validate($capaciteBrute)) {
            $errors['capacite'][] = 'La capacité doit être un entier compris entre 1 et 1000.';
        }

        $type = $data['type'] ?? null;
        if (!v::stringType()->in(Salle::TYPES)->validate($type)) {
            $errors['type'][] = "Le type doit être l'une des valeurs suivantes : "
                . implode(', ', Salle::TYPES) . '.';
        }

        $activeBrute = $data['active'] ?? false;
        if (!v::boolVal()->validate($activeBrute)) {
            $errors['active'][] = 'Le statut actif doit être une valeur booléenne.';
        }

        if ([] !== $errors) {
            return ValidationResult::failure($errors);
        }

        return ValidationResult::success([
            'nom' => $nom,
            'batiment' => $batiment,
            'capacite' => (int) $capaciteBrute,
            'type' => $type,
            'active' => (bool) $activeBrute,
        ]);
    }
}
