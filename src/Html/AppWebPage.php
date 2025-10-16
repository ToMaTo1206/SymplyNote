<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{

    private string $menu = '';
    /**
     * Constructeur.
     *
     * @param string $title Titre de la page
     */
    public function __construct(string $title = '')
    {
        parent::__construct($title);
    }

    public function appendMenu(string $content): void
    {
        $this->menu .= $content;
    }

    public function getMenu(): string{
        return $this->menu;
    }
    /**
     * Produire la page Web complète.
     */
    public function toHTML(): string
    {
        $lastModification = self::getLastModification();

        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{$this->getTitle()}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
{$this->getHead()}
    </head>
    <body class="container-fluid d-flex flex-column vh-100 bg-success-subtle">
        <header class="d-flex justify-content-center align-items-center">
            <h1 class="d-flex justify-content-center m-2">{$this->getTitle()}</h1>
            {$this->getMenu()}
        </header>
        <section class="container-fluid d-flex justify-content-center align-items-center flex-grow-1"> 
{$this->getBody()}
        </section>
        <footer class="column-gap-3">
            <div></div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
HTML;
    }
}
