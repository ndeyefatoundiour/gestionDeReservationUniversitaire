<?php

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$capsule = require_once dirname(__DIR__, 2) . '/config/database.php';


use Illuminate\Database\Capsule\Manager as Capsule;

if (!Capsule::schema()->hasTable('salles')) {
    Capsule::schema()->create('salles', function ($table) {
        $table->increments('id');
        $table->string('nom');
        $table->string('batiment');
        $table->integer('capacite');
        $table->enum('type', ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion']);
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
}

echo "Table 'salles' recréée avec succès !\n";
