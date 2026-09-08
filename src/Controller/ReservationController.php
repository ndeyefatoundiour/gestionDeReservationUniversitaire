<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\CreerReservationService;
use App\Service\AnnulerReservationService;
use App\Validation\ReservationValidator;
use App\Exception\SalleIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Exception\PeriodeInvalideException;
use App\Exception\ReservationIntrouvableException;
use App\View\Renderer;

final class ReservationController
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepository,
        private readonly SalleRepositoryInterface $salleRepository,
        private readonly ReservationValidator $reservationValidator,
        private readonly CreerReservationService $creerReservationService,
        private readonly AnnulerReservationService $annulerReservationService,
        private readonly Renderer $renderer
    ) {
    }

    public function index(): void
    {
        $reservations = $this->reservationRepository->listerTous();
        echo $this->renderer->render('reservation/index', ['reservations' => $reservations]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->trouverParId($id);
        if (null === $reservation) {
            header("HTTP/1.1 404 Not Found");
            echo $this->renderer->render('error/404');
            return;
        }
        echo $this->renderer->render('reservation/show', ['reservation' => $reservation]);
    }

    public function create(): void
    {
        $salles = $this->salleRepository->listerTous();
        echo $this->renderer->render('reservation/form', ['salles' => $salles]);
    }

    public function store(): void
    {
        $salles = $this->salleRepository->listerTous();

        // 1 & 2. Lire les données HTTP et appeler le validateur syntaxique
        $resultat = $this->reservationValidator->validate($_POST);

        // 3. Réafficher le formulaire en cas d'erreur de format
        if (!$resultat->isValid()) {
            echo $this->renderer->render('reservation/form', [
                'salles' => $salles,
                'errors' => $resultat->errors(),
                'old'    => $_POST
            ]);
            return;
        }

        // 4. Récupérer le DTO déjà construit par le validateur
        $dto = $resultat->data();

        try {
            // 5. Appeler le service métier
            $this->creerReservationService->executer($dto);
            
            // 6. Rediriger après succès (Pattern PRG)
            header('Location: /reservations');
            exit;
        } catch (SalleIntrouvableException | SalleIndisponibleException | PeriodeInvalideException $e) {
            // Attribuer l'erreur métier au bon champ pour affichage ciblé
            $champ = ($e instanceof PeriodeInvalideException) ? 'date_debut' : 'salle_id';
            
            echo $this->renderer->render('reservation/form', [
                'salles' => $salles,
                'errors' => [$champ => [$e->getMessage()]],
                'old'    => $_POST
            ]);
        }
    }

    public function cancel(int $id): void
    {
        try {
            $this->annulerReservationService->executer($id);
            header('Location: /reservations');
            exit;
        } catch (ReservationIntrouvableException $e) {
            header("HTTP/1.1 404 Not Found");
            echo $this->renderer->render('error/404');
        }
    }
}
