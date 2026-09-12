<?php

require_once dirname(__DIR__, 1) . '/vendor/autoload.php';
$capsule = require dirname(__DIR__, 1) . '/config/database.php';

use App\Model\Salle;

echo "Remplissage de la base de données (Seeding)...\n";

$sallesPredefinies = [
    [
        'nom' => 'Amphithéâtre A',
        'batiment' => 'Bâtiment Principal',
        'capacite' => 250,
        'type' => 'amphitheatre',
        'active' => true
    ],
    [
        'nom' => 'Salle B12',
        'batiment' => 'Bâtiment B',
        'capacite' => 40,
        'type' => 'cours',
        'active' => true
    ],
    [
        'nom' => 'Laboratoire Chimie',
        'batiment' => 'Bâtiment Sciences',
        'capacite' => 24,
        'type' => 'laboratoire',
        'active' => true
    ],
    [
        'nom' => 'Salle Informatique 1',
        'batiment' => 'Bâtiment Informatique',
        'capacite' => 30,
        'type' => 'informatique',
        'active' => true
    ],
    [
        'nom' => 'Salle de réunion',
        'batiment' => 'Administration',
        'capacite' => 12,
        'type' => 'reunion',
        'active' => true
    ]
];

foreach ($sallesPredefinies as $donneesSalle) {
    
    Salle::updateOrCreate(['nom' => $donneesSalle['nom']],$donneesSalle);
}

echo "Données initiales insérées avec succès dans MySQL !\n";
