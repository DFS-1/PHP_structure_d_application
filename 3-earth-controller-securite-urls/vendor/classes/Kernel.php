<?php

namespace vendor\classes;

use vendor\classes\Router;
use App\controller\AppController;

class Kernel
{
    public static function bootstrap()
    {
        $router = new Router();

        $appController = new AppController();
        $controllerMethod = $router->getControllerMethod(); // home
        if (method_exists($appController, $controllerMethod)) { // si la méthode home existe dans AppController
            $appController->$controllerMethod(); // on appelle la méthode home de appController
        } else {
            $appController->notFound();
        }
    }
}
