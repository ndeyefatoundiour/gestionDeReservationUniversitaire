<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Exception\DonneesInvalidesException;
use App\Repository\SalleRepositoryInterface;
use App\Service\CreerSalleService;
use App\Service\ModifierSalleService;
use App\View\Renderer;

final class SalleController
{
    public function __construct(
        private readonly SalleRepositoryInterface $salles,
        private readonly CreerSalleService $creerSalleService,
        private readonly ModifierSalleService $modifierSalleService,
        private readonly Renderer $renderer,
    ) {
    }

    public function index(array $params): void
    {
        $this->renderer->render('salle/index', ['salles' => $this->salles->listerTous()]);
    }

    public function create(array $params): void
    {
        $this->renderer->render('salle/form', ['isEdit' => false, 'errors' => [], 'old' => []]);
    }

    public function store(array $params): void
    {
        try {
            $dto = CreerSalleDTO::depuisDonnees($_POST);
        } catch (DonneesInvalidesException $exception) {
            $this->renderer->render('salle/form', [
                'isEdit' => false,
                'errors' => $exception->errors(),
                'old' => $_POST,
            ]);
            return;
        }

        $salle = $this->creerSalleService->creer($dto);
        $this->rediriger('/salles/' . $salle->id);
    }

    public function show(array $params): void
    {
        $salle = $this->salles->trouverParId((int) $params['id']);
        if (null === $salle) {
            http_response_code(404);
            $this->renderer->render('error/404');
            return;
        }

        $this->renderer->render('salle/show', ['salle' => $salle]);
    }

    public function edit(array $params): void
    {
        $salle = $this->salles->trouverParId((int) $params['id']);
        if (null === $salle) {
            http_response_code(404);
            $this->renderer->render('error/404');
            return;
        }

        $this->renderer->render('salle/form', [
            'isEdit' => true,
            'salle' => $salle,
            'errors' => [],
            'old' => [],
        ]);
    }

    public function update(array $params): void
    {
        $id = (int) $params['id'];
        $salle = $this->salles->trouverParId($id);
        if (null === $salle) {
            http_response_code(404);
            $this->renderer->render('error/404');
            return;
        }

        try {
            $dto = CreerSalleDTO::depuisDonnees($_POST);
        } catch (DonneesInvalidesException $exception) {
            $this->renderer->render('salle/form', [
                'isEdit' => true,
                'salle' => $salle,
                'errors' => $exception->errors(),
                'old' => $_POST,
            ]);
            return;
        }

        $this->modifierSalleService->modifier($salle, $dto);
        $this->rediriger('/salles/' . $id);
    }

    private function rediriger(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
