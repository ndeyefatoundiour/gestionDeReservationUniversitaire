<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\DonneesInvalidesException;
use App\Exception\PeriodeInvalideException;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Exception\SalleIntrouvableException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\View\Renderer;

final class ReservationController
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly SalleRepositoryInterface $salles,
        private readonly CreerReservationService $creerReservationService,
        private readonly AnnulerReservationService $annulerReservationService,
        private readonly Renderer $renderer,
    ) {
    }

    
    public function index(array $params): void
    {
        $salleId = (isset($_GET['salle_id']) && '' !== $_GET['salle_id'])
            ? (int) $_GET['salle_id']
            : null;

        $this->renderer->render('reservation/index', [
            'reservations' => $this->reservations->listerTous(),
            'salles' => $this->salles->listerTous(),
            'selectedSalleId' => $salleId,
        ]);
    }

    
    public function show(array $params): void
    {
        $reservation = $this->reservations->trouverParId((int) $params['id']);

        if (null === $reservation) {
            http_response_code(404);
            $this->renderer->render('error/404');
            return;
        }

        $this->renderer->render('reservation/show', [
            'reservation' => $reservation,
        ]);
    }

    
    public function create(array $params): void
    {
        $this->renderer->render('reservation/form', [
            'salles' => $this->sallesActives(),
            'errors' => [],
            'old' => [],
        ]);
    }

    
    public function store(array $params): void
    {
        try {
            $dto = CreerReservationDTO::depuisDonneesValidees($_POST);
        } catch (DonneesInvalidesException $exception) {
            $this->afficherFormulaireAvecErreurs($exception->errors(), $_POST);
            return;
        }

        try {
            $reservation = $this->creerReservationService->creer($dto);
        } catch (SalleIntrouvableException|SalleIndisponibleException|PeriodeInvalideException $exception) {
            $this->afficherFormulaireAvecErreurs(
                ['salle_id' => [$exception->getMessage()]],
                $_POST,
            );
            return;
        }

        $this->rediriger('/reservations/' . $reservation->id, 'Réservation confirmée.');
    }

    
    public function cancel(array $params): void
    {
        $id = (int) $params['id'];

        try {
            $this->annulerReservationService->annuler($id);
        } catch (ReservationIntrouvableException) {
            http_response_code(404);
            $this->renderer->render('error/404');
            return;
        }

        $this->rediriger('/reservations/' . $id, 'Réservation annulée.');
    }

   
    private function sallesActives(): array
    {
        return $this->salles->listerTous()
            ->filter(static fn ($salle) => $salle->active)
            ->values()
            ->all();
    }

    
    private function afficherFormulaireAvecErreurs(array $errors, array $old): void
    {
        $this->renderer->render('reservation/form', [
            'salles' => $this->sallesActives(),
            'errors' => $errors,
            'old' => $old,
        ]);
    }

   
    private function rediriger(string $url, string $messageSucces): void
    {
        $_SESSION['flash_success'] = $messageSucces;
        header('Location: ' . $url);
        exit;
    }
}
