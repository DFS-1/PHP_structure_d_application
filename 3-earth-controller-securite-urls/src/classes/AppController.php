<?php

class AppController
{
    public function __construct() {}

    public function home()
    {
        $this->render('home');
    }
    public function about()
    {
        $this->render('about');
    }
    public function services()
    {
        $this->render('services');
    }
    public function contact()
    {
        $this->render('contact');
    }
    public function notFound()
    {
        $this->render('404');
    }

    private function render($page)
    {
        $pagePath = PAGES . $page . ".php"; // le chemin complet de la page
        if (!file_exists($pagePath)) {
            header('location:index.php?page=' . NOT_FOUND_ROUTE);
        }
        include TEMPLATE . 'base.php';
    }
}
