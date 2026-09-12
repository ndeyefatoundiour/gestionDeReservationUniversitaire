<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use PHPUnit\Framework\TestCase;

final class ValidatorsTest extends TestCase
{
    public function testValidationReservationInvalide(): void
    {
        $validator = new ReservationValidator();
        $resultat = $validator->validate([
            'salle_id' => 1,
            'responsable' => '   ', 
            'email' => 'fausse-adresse.sn', 
            'motif' => 'Cours',
            'date_debut' => '2027-10-15 10:00:00',
            'date_fin' => '2027-10-15 12:00:00'
        ]);

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('responsable', $resultat->errors());
        $this->assertArrayHasKey('email', $resultat->errors());
    }

    public function testValidationReservationResponsableTexte(): void
    {
        $validator = new ReservationValidator();

        $resultatValide = $validator->validate([
            'salle_id' => 1,
            'responsable' => 'Professeur Diop',
            'email' => 'prof@univ.sn',
            'motif' => 'Cours de PHP',
            'date_debut' => '2027-10-15 10:00:00',
            'date_fin' => '2027-10-15 12:00:00'
        ]);

        $this->assertTrue($resultatValide->isValid());
        $this->assertSame('Professeur Diop', $resultatValide->data()['responsable']);

        $resultatInvalide = $validator->validate([
            'salle_id' => 1,
            'responsable' => 'A',
            'email' => 'prof@univ.sn',
            'motif' => 'Cours de PHP',
            'date_debut' => '2027-10-15 10:00:00',
            'date_fin' => '2027-10-15 12:00:00'
        ]);

        $this->assertFalse($resultatInvalide->isValid());
        $this->assertArrayHasKey('responsable', $resultatInvalide->errors());
    }

    public function testValidationSalleInvalide(): void
    {
        $validator = new SalleValidator();
        $resultat = $validator->validate([
            'nom' => 'Salle 101',
            'batiment' => 'Bâtiment A',
            'capacite' => -50, 
            'type' => 'cuisine', 
            'active' => true
        ]);

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('capacite', $resultat->errors());
        $this->assertArrayHasKey('type', $resultat->errors());
    }
}
