<?php

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$capsule = require_once dirname(__DIR__, 2) . '/config/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

if (!Capsule::schema()->hasTable('reservations')) {
    Capsule::schema()->create('reservations', function ($table) {
        $table->increments('id');
        $table->integer('salle_id')->unsigned();
        $table->string('responsable');
        $table->string('email');
        $table->string('motif');
        $table->dateTime('date_debut');
        $table->dateTime('date_fin');
        $table->enum('statut', ['confirmée', 'annulée'])->default('confirmée');
        $table->timestamps();

        $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
    });
}

echo " Table 'reservations' créée avec succès !\n";
