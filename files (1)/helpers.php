<?php

declare(strict_types=1);

/*
 * Fonctions utilitaires réservées aux vues.
 * Elles ne contiennent aucune règle métier : uniquement de l'échappement
 * et de la relecture de valeurs déjà validées / soumises.
 *
 * A charger une seule fois depuis public/index.php, par exemple :
 *   require __DIR__ . '/../src/View/helpers.php';
 */

if (!function_exists('e')) {
    /**
     * Échappe une valeur pour un affichage HTML sûr.
     */
    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('old')) {
    /**
     * Récupère une valeur précédemment soumise (après une erreur de validation),
     * avec une valeur par défaut, déjà échappée.
     */
    function old(array $old, string $key, string $default = ''): string
    {
        return e($old[$key] ?? $default);
    }
}

if (!function_exists('has_error')) {
    /**
     * Indique si un champ possède une erreur de validation.
     */
    function has_error(array $errors, string $key): bool
    {
        return !empty($errors[$key]);
    }
}

if (!function_exists('field_error')) {
    /**
     * Affiche la liste des messages d'erreur pour un champ donné.
     */
    function field_error(array $errors, string $key): string
    {
        if (empty($errors[$key])) {
            return '';
        }

        $messages = is_array($errors[$key]) ? $errors[$key] : [$errors[$key]];

        $html = '<ul class="field-errors">';
        foreach ($messages as $message) {
            $html .= '<li>' . e($message) . '</li>';
        }

        return $html . '</ul>';
    }
}

if (!function_exists('flash')) {
    /**
     * Dépose un message flash en session, affiché puis effacé à la vue suivante.
     */
    function flash(string $type, string $message): void
    {
        $_SESSION['flash_' . $type] = $message;
    }
}
