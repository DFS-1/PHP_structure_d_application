<?php

class Router
{
    private string $page;

    public function __construct()
    {
        $this->page = isset($_GET["page"]) ? $_GET["page"] : "home";
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function getPath(): string
    {
        $pagePath = PAGES . $this->page . ".php"; // le chemin complet de la page
        if (!file_exists($pagePath)) {
            header("location:index.php?page=404"); // on redirige vers 404.php
        }
        return $pagePath;
    }
}
