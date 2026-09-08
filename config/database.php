<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

try {
    $capsule->addConnection([
    'driver'    => $_ENV['DB_DRIVER'] ?? 'mysql',
    'host'      => $_ENV['DB_HOST'] ?? 'db', 
    'database'  => $_ENV['DB_DATABASE'] ?? 'reservation_salles',
    'username'  => $_ENV['DB_USERNAME'] ?? 'root',
    'password'  => $_ENV['DB_PASSWORD'] ?? 'root_password',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);


    $capsule->setAsGlobal();
    
    $capsule->bootEloquent();
    
    $capsule->getConnection()->getPdo();
    
} catch (\Exception $e) {
    
    die("Erreur critique de connexion à la base de données : " . $e->getMessage());
}

return $capsule;
