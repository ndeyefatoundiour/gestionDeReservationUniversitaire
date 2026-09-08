<?php

declare(strict_types=1);


if (!function_exists('e')) {
    
    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('old')) {
    
    function old(array $old, string $key, string $default = ''): string
    {
        return e($old[$key] ?? $default);
    }
}

if (!function_exists('has_error')) {
    
    function has_error(array $errors, string $key): bool
    {
        return !empty($errors[$key]);
    }
}

if (!function_exists('field_error')) {
    
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
    
    function flash(string $type, string $message): void
    {
        $_SESSION['flash_' . $type] = $message;
    }
}
