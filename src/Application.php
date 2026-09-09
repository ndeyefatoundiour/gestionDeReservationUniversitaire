<?php

declare(strict_types=1);

namespace App;

final class Application
{
    public function run(): void
    {
        if (PHP_SAPI !== 'cli') {
            return;
        }

        $this->runCommand($_SERVER['argv'][1] ?? null);
    }

    private function runCommand(?string $command): void
    {
        switch ($command) {
            case 'migrate':
                $this->runMigration();
                break;

            case 'seed':
                require dirname(__DIR__) . '/database/seed.php';
                break;

            case 'setup':
                $this->runMigration();
                require dirname(__DIR__) . '/database/seed.php';
                break;

            default:
                fwrite(STDERR, "Commande inconnue. Utilisez : migrate, seed ou setup.\n");
                exit(1);
        }
    }

    private function runMigration(): void
    {
        require dirname(__DIR__) . '/database/migrations/create_salles_table.php';
        require dirname(__DIR__) . '/database/migrations/create_reservations_table.php';
        echo "Migrations exécutées avec succès.\n";
    }
}
