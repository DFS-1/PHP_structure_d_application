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

    private function render($page)
    {
        include TEMPLATE . 'base.php';
    }
}
