<?php

declare(strict_types=1);

namespace App\View;

final class Renderer
{
    private string $templatePath;

    public function __construct()
    {
        $this->templatePath = dirname(__DIR__, 2) . '/templates/';
    }

    /**
     * Rend un template avec ses données et l'injecte dans le layout de base.
     */
    public function render(string $view, array $data = []): string
    {
        // Fonction d'échappement sécurisée accessible dans les vues
        $e = static function (mixed $value): string {
            return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
        };

        // Extrait les variables pour les rendre disponibles dans le fichier de la vue
        extract($data);

        // 1. Capture le contenu de la vue spécifique
        unset($data); // Sécurité
        ob_start();
        require $this->templatePath . $view . '.php';
        $content = ob_get_clean();

        // 2. Injecte ce contenu dans le layout principal
        ob_start();
        require $this->templatePath . 'layout/base.php';
        return ob_get_clean();
    }
}
