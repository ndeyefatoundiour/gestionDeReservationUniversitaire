<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$driver = $_ENV['DB_DRIVER'] ?? getenv('DB_DRIVER') ?: 'mysql';
$host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: 3306;
$database = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE');
$username = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME');
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');

if ($host === false || $host === null || $host === '' || $database === false || $database === null || $database === '' || $username === false || $username === null || $username === '' || $password === false || $password === null || $password === '') {
    throw new \RuntimeException('Configuration DB incomplète. Vérifie DB_HOST, DB_DATABASE, DB_USERNAME et DB_PASSWORD dans Render ou dans le .env.');
}

try {
    $capsule->addConnection([
        'driver' => $driver,
        'host' => $host,
        'port' => (int) $port,
        'database' => $database,
        'username' => $username,
        'password' => $password,
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
