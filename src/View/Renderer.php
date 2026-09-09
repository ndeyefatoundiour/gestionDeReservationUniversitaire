<?php

declare(strict_types=1);

namespace App\View;


final class Renderer
{
    private readonly string $templatesPath;

    public function __construct()
    {
        $this->templatesPath = dirname(__DIR__, 2) . '/templates';
    }

   
    public function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        ob_start();
        
        require $this->templatesPath . '/' . $template . '.php';
        
        $outputBrut = ob_get_clean();

        if (isset($content)) {
            require $this->templatesPath . '/layout/base.php';
        } else {
            echo $outputBrut;
        }
    }
}
