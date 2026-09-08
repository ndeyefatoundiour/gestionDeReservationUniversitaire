<?php

declare(strict_types=1);

namespace App\Exception;

final class PeriodeInvalideException extends \RuntimeException
{
    public static function finAvantDebut(): self
    {
        return new self('La date de fin doit être postérieure à la date de début.');
    }

    public static function dureeExcessive(): self
    {
        return new self('Une réservation ne peut pas dépasser quatre heures.');
    }

    public static function dateDansLePasse(): self
    {
        return new self('La réservation doit commencer dans le futur.');
    }
}
