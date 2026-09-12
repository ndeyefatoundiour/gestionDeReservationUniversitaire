<?php

declare(strict_types=1);

use App\Application;
use App\HttpApplication;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Service\CreerSalleService;
use App\Service\ModifierReservationService;
use App\Service\ModifierSalleService;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use App\View\Renderer;
use Illuminate\Database\Capsule\Manager as Capsule;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

use function DI\autowire;
use function DI\factory;
use function DI\get;

return [

    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),

    SalleValidator::class       => autowire(),
    ReservationValidator::class => autowire(),
    Renderer::class             => autowire(),

    CreerReservationService::class    => autowire(),
    ModifierReservationService::class => autowire(),
    AnnulerReservationService::class  => autowire(),
    CreerSalleService::class          => autowire(),
    ModifierSalleService::class       => autowire(),

    SalleController::class       => autowire(),
    ReservationController::class => autowire(),

    Capsule::class => factory(function (): Capsule {
        return require dirname(__DIR__) . '/config/database.php';
    }),

    Dispatcher::class => factory(function (): Dispatcher {
        return require dirname(__DIR__) . '/routes/web.php';
    }),

    Application::class => autowire(),
    HttpApplication::class => factory(function (ContainerInterface $container): HttpApplication {
        $container->get(Capsule::class);

        return new HttpApplication(
            $container->get(Dispatcher::class),
            $container,
        );
    }),
];
