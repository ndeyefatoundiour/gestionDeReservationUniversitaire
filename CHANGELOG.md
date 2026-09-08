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

## V0.4.0 - Données initiales

- Script `database/seed.php` : cinq salles de référence, idempotent.

## V0.5.0 - Validation

- `ValidatorInterface`, `ValidationResult`.
- `SalleValidator` et `ReservationValidator` basés sur Respect\Validation.

## V0.6.0 - Objets de transport

- `CreerSalleDTO` et `CreerReservationDTO`, construits uniquement à partir de
  données déjà validées.

## V0.7.0 - Accès aux données

- Interfaces `SalleRepositoryInterface` et `ReservationRepositoryInterface`.
- Implémentations Eloquent correspondantes, y compris la recherche de chevauchement.

## V0.8.0 - Services métier

- `CreerReservationService` : implémente les 9 règles de disponibilité.
- `AnnulerReservationService`.
- Exceptions dédiées : `SalleIntrouvableException`, `SalleIndisponibleException`

## V0.9.0 - Interface web

- Contrôleurs `SalleController` et `ReservationController`.
- Vues : layout de base, listes, détails, formulaires, pages d'erreur.
- Échappement systématique des sorties dynamiques.

## V0.10.0 - Routeur

- Déclaration des routes dans `routes/web.php`.
- Dispatch FastRoute avec gestion des réponses 404 et 405 (en-tête `Allow`).
- Résolution des contrôleurs via le conteneur depuis `App\Application`.
