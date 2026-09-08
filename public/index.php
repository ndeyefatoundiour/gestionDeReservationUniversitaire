<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$capsule = require_once __DIR__ . '/../config/database.php';

echo "✅ Connexion réussie à MySQL avec l'utilisateur root sous Docker !";
