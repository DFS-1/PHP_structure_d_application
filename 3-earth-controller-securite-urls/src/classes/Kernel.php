<?php
require_once CLASSES . 'Router.php';
require_once CLASSES . 'AppController.php';

class Kernel
{
    public function bootstrap()
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
