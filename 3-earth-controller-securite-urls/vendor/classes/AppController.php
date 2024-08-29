<?php

namespace vendor\classes;

use vendor\classes\AbstractController;

class AppController extends AbstractController
{
    public function __construct() {}

    public function home()
    {
        $this->render('home', [
            'title' => 'HOME'
        ]);
    }
    public function about()
    {
        $this->render('about', [
            'title' => 'ABOUT'
        ]);
    }
    public function services()
    {
        $this->render('services', [
            'title' => 'SERVICES',
        ]);
    }
    public function contact()
    {
        $this->render('contact', [
            'title' => 'CONTACT'
        ]);
    }
    public function connexion()
    {
        $this->render('connexion', [
            'title' => 'CONNEXION'
        ]);
    }

    public function notFound()
    {
        $this->render('404', ['title' => '404']);
    }
}
