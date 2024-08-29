<?php

namespace vendor\classes;

abstract class AbstractController
{
    protected function render($page, $params = null)
    {
        $pagePath = PAGES . $page . ".php"; // le chemin complet de la page
        if (!file_exists($pagePath)) {
            header('location:index.php?page=' . NOT_FOUND_ROUTE);
        }
        if ($params != null) {
            extract($params);
        }
        include TEMPLATE . 'base.php';
    }
}
