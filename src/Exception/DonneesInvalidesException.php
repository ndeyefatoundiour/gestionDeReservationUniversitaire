<?php

declare(strict_types=1);

namespace App\Exception;

final class DonneesInvalidesException extends \RuntimeException
{
    public function __construct(private readonly array $errors)
    {
        parent::__construct('Les données du formulaire sont invalides.');
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
