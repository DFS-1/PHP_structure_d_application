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
        include TEMPLATE . 'base.php';
    }
}
