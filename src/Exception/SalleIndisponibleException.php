<?php

declare(strict_types=1);

namespace App\Exception;

final class SalleIndisponibleException extends \RuntimeException
{
    public static function inactive(): self
    {
        return new self('Cette salle ne peut pas être réservée.');
    }

    public static function conflitHoraire(): self
    {
        return new self('La salle est indisponible pendant cette période.');
    }
}
