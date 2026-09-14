<?php

declare(strict_types=1);

namespace App;

use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Service\CreerSalleService;
use App\Service\ModifierReservationService;
use App\Service\ModifierSalleService;
use App\View\Renderer;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

final class HttpApplication
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
        private readonly ContainerInterface $container,
    ) {
    }

    public function run(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        if (false !== $position = strpos($uri, '?')) {
            $uri = substr($uri, 0, $position);
        }

        $routeInfo = $this->dispatcher->dispatch($httpMethod, rawurldecode($uri));

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                $this->container->get(Renderer::class)->render('error/404');
                return;

            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                header('Allow: ' . implode(', ', $routeInfo[1]));
                $this->container->get(Renderer::class)->render('error/405');
                return;

            case Dispatcher::FOUND:
                [$controllerClass, $method] = $routeInfo[1];
                $controller = $this->resolveController($controllerClass);
                $controller->$method($routeInfo[2]);
                return;
        }
    }

    private function resolveController(string $controllerClass): object
    {
        return match ($controllerClass) {
            ReservationController::class => new ReservationController(
                $this->container->get(ReservationRepositoryInterface::class),
                $this->container->get(SalleRepositoryInterface::class),
                $this->container->get(CreerReservationService::class),
                $this->container->get(ModifierReservationService::class),
                $this->container->get(AnnulerReservationService::class),
                $this->container->get(Renderer::class),
            ),
            SalleController::class => new SalleController(
                $this->container->get(SalleRepositoryInterface::class),
                $this->container->get(CreerSalleService::class),
                $this->container->get(ModifierSalleService::class),
                $this->container->get(Renderer::class),
            ),
            default => throw new \RuntimeException('Contrôleur non géré : ' . $controllerClass),
        };
    }
}
