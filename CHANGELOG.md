
## V1.0.0- Initialisation du dépôt

- Dépôt Git initialisé, `.gitignore`, `README.md`, `CHANGELOG.md`.

## V0.1.0 - Composer

- Initialisation du projet Composer, autoloading PSR-4, arborescence du projet.

## V0.2.0 - Eloquent

- Configuration de `Capsule\Manager` à partir des variables d'environnement.
- Chargement de `.env` via `vlucas/phpdotenv`.
- Création de scripts de migration SQL isolés (`create_salles_table.php` et `create_reservations_table.php`) avec gestion des contraintes de clés étrangères.

## V0.3.0 - Modèles

- Modèles Eloquent `Salle` et `Reservation`, relation `hasMany` / `belongsTo`.
