<?php

namespace vendor\classes;

class Router
{
    private string $page;

    public function __construct()
    {
        $this->page = isset($_GET["page"]) ? $_GET["page"] : HOMEPAGE;
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function getControllerMethod()
    {
        if (array_key_exists($this->page, ROUTES)) {
            return ROUTES[$this->page];
        }
        return NOT_FOUND_ROUTE; // 404
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
