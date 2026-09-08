<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$capsule = require_once __DIR__ . '/../../config/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->disableForeignKeyConstraints();

Capsule::schema()->dropIfExists('salles');

Capsule::schema()->enableForeignKeyConstraints();

Capsule::schema()->create('salles', function ($table) {
    $table->increments('id');
    $table->string('nom');
    $table->string('batiment');
    $table->integer('capacite');
    $table->enum('type', ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion']);
    $table->boolean('active')->default(true);
    $table->timestamps();
});

echo "Table 'salles' recréée avec succès !\n";
