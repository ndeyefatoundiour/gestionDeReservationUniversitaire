<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

try {
    $capsule->addConnection([
        'driver' => $_ENV['DB_DRIVER'] ,
        'host' => $_ENV['DB_HOST'] ,
        'port' => (int) ($_ENV['DB_PORT']),
        'database' => $_ENV['DB_DATABASE'] ,
        'username' => $_ENV['DB_USERNAME'] ,
        'password' => $_ENV['DB_PASSWORD'] ,
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    $capsule->getConnection()->getPdo();

} catch (\Exception $exception) {

    throw new \RuntimeException('Erreur critique de connexion à la base de données : ' . $exception->getMessage(),
        0,
        $exception,
    );
}

return $capsule;
