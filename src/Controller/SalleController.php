<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;
use App\View\Renderer;

final class SalleController
{
    public function __construct(
        private readonly SalleRepositoryInterface $salleRepository,
        private readonly SalleValidator $salleValidator,
        private readonly Renderer $renderer
    ) {
    }

    public function index(): void
    {
        $salles = $this->salleRepository->listerTous();
        echo $this->renderer->render('salle/index', ['salles' => $salles]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleRepository->trouverParId($id);
        if (null === $salle) {
            header("HTTP/1.1 404 Not Found");
            echo $this->renderer->render('error/404');
            return;
        }
        echo $this->renderer->render('salle/show', ['salle' => $salle]);
    }

    public function create(): void
    {
        echo $this->renderer->render('salle/form', ['isEdit' => false]);
    }

    public function store(): void
    {
        // 1 & 2. Lire les données et appeler le validateur
        $resultat = $this->salleValidator->validate($_POST);

        // 3. Réafficher le formulaire en cas d'erreur
        if (!$resultat->isValid()) {
            echo $this->renderer->render('salle/form', [
                'isEdit' => false,
                'errors' => $resultat->errors(),
                'old'    => $_POST
            ]);
            return;
        }

        // 4 & 5. Le validateur a déjà construit le DTO et appelé le service/repository
        $dto = $resultat->data();
        $this->salleRepository->enregistrer($dto);

        // 6. Rediriger après succès
        header('Location: /salles');
        exit;
    }

    public function edit(int $id): void
    {
        $salle = $this->salleRepository->trouverParId($id);
        if (null === $salle) {
            header("HTTP/1.1 404 Not Found");
            echo $this->renderer->render('error/404');
            return;
        }
        echo $this->renderer->render('salle/form', ['isEdit' => true, 'salle' => $salle]);
    }

    public function update(int $id): void
    {
        $salle = $this->salleRepository->trouverParId($id);
        if (null === $salle) {
            header("HTTP/1.1 404 Not Found");
            echo $this->renderer->render('error/404');
            return;
        }

        $resultat = $this->salleValidator->validate($_POST);

        if (!$resultat->isValid()) {
            echo $this->renderer->render('salle/form', [
                'isEdit' => true,
                'salle'  => $salle,
                'errors' => $resultat->errors(),
                'old'    => $_POST
            ]);
            return;
        }

        $dto = $resultat->data();
        $salle->update([
            'nom' => $dto->nom,
            'batiment' => $dto->batiment,
            'capacite' => $dto->capacite,
            'type' => $dto->type,
            'active' => $dto->active
        ]);

        header('Location: /salles/' . $id);
        exit;
    }
}
