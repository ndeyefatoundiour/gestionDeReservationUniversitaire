<?php

use App\Database\CapsuleManager;

try {
    $capsule = CapsuleManager::create();
    
    $capsule->getConnection()->getPdo();
    
} catch (\Exception $e) {
    
    die("Erreur critique de connexion à la base de données : " . $e->getMessage());
}

return $capsule;
