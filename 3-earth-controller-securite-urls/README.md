# STRUCTURE D'APPLICATION #3 - MVC

> !! Avant de faire cet exercice, vous devez avoir fait celui-ci : [2-earth-routing](https://github.com/DFS-1/2-earth-routing) !!

> On s'oriente vers une architecture Model View Controller.\
> En quoi cela consiste-t-il ?\
> Ici, c'est surtout la partie controller qui va nous intéresser.\
> Un controller est une classe dont chacune des méthodes va correspondre à une route, accessible via une url.\
> Dans chaque méthode d'un controller, on pourra effectuer un traitement - comme récupérer des données en base de données - puis on appellera la méthode *render()* du controller qui effectuera le rendu (include du template).\
> L'appel à la méthode de controller se fera à partir d'une classe Kernel.

## ETAPE 1 : structure, encore !

### Dossier controller

- Créer un dossier *controller* dans le dossier *src* ainsi que la constante correspondante.
- Dans ce dossier, créer un fichier *AppController.php* pour la classe AppController.

## ETAPE 2 : la classe controller

### Structure et rôle

- La classe controller (que nous appellerons *AppController*, comme le nom du fichier par convention) contiendra des méthodes appelées en fonction du paramètre d'url *page*.
- Dans chaque méthode de controller, nous effectuerons les actions voulues : affichage de page, requêtes sur la base de données, retour de texte brut (json),...
- Nous créerons ensuite une 3ème classe chargée de récupérer le nom de la méthode de controller à appeler (via le router) et d'appeler cette méthode. Nous nommerons cette 3ème classe *Kernel*. Elle sera chargée depuis *index.php*.

> La classe AppController :

```php
<?php
class AppController
{
    public function __construct()
    {
    }

    public function home()
    {
        $this->render("home");
    }
    public function about()
    {
        $this->render("about");
    }
    public function services()
    {
        $this->render("services");
    }
    public function contact()
    {
        $this->render("contact");
    }
    public function render($page)
    {
        include TEMPLATE . 'base.php';
    }
}
```

> On a une méthode par page.\
> Il y a une méthode particulière - *render* - que nous pourrons appeler chaque fois que nous souhaiterons afficher une page (on peut très bien aussi renvoyer du json avec *echo*).\
> Nous allons modifier le *router* de manière à appeler la bonne méthode pour une url donnée.

## ETAPE 3 : la classe router

> D'où partons-nous ?

```php
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
```

> Cette classe fait des actions qui ne lui incombent pas, comme la redirection.\
> Nous allons faire en sorte qu'elle nous renvoie le nom de la méthode de controller à appeler. Nous en profiterons pour vérifier que la route ciblée via l'url est bien présente dans une liste de routes prévues à l'avance (un tableau que nous stockerons dans un fichier séparé).

> On commence par créer cette liste de routes.\
> Pour cela, nous créons un fichier *src/config/routes.php*. 

```php
<?php

return [
    "home" => "home",
    "about" => "about",
    "services" => "services",
    "contact" => "contact",
    "404" => "404"
];
```

> Ce fichier renvoie un tableau associatif. Chaque clé représente le paramètre d'url *page* et chaque valeur représente la méthode de controller ciblée. Même si ce tableau semble inutile, il assure qu'on ne pourra pas appeler directement toutes les méthodes de *AppController*. En effet, il se peut que certaines de ces méthodes ne correspondent pas à une page. Ici, les valeurs des clés et des valeurs sont les mêmes, mais cela n'est pas forcément le cas.\
> Il faut créer une constante *ROUTES* dans *config.php* pour le retour de ce fichier :

```php
define("ROUTES", include SRC . 'config/routes.php');
```

> On crée une constante *HOMEPAGE* égale à "home".
> On crée également une constante *NOT_FOUND_ROUTE* égale à "404".

```php
    define("HOMEPAGE", "home");
```

> La class *Router* devient :

```php
<?php

class Router
{
    private string $route;

    public function __construct()
    {
        $this->route = isset($_GET["page"]) ? $_GET["page"] : HOMEPAGE;
    }

    public function getControllerMethod()
    {
        if (array_key_exists($this->route, ROUTES)) { //choix de la page dans le tableau associatif
            return ROUTES[$this->route];
        }
        return NOT_FOUND_ROUTE; // on affiche la page 404 sans rediriger => l'utilisateur voit toujours l'url qu'il a ciblée
    }
}
```

> La méthode *getControllerMethod()* nous renvoie la méthode de controller à appeler.\
> Nous allons créer une nouvelle classe pour appeler cette méthode, la classe *Kernel*

## ETAPE 4 : la classe kernel

> Pourquoi ?\
> Simplement pour ne pas mettre de la logique dans *index.php*.\
> On regarde...

```php
<?php
require_once CLASSES . 'Router.php';
require_once CLASSES . 'AppController.php';

class Kernel
{
    public function bootstrap()
    {
        $this->router = new Router();
        $controller = new AppController();
        $controllerMethod = $this->router->getControllerMethod();
        if (method_exists($controller, $controllerMethod)) {
            $controller->$controllerMethod(); //appel de la méthode du controller
        } else {
            $controller->notFound();
        }
    }
}
```

> Pfiou !\
> Ici, on aborde les premiers vrais concepts de *Programmation Orientée Objet*.\
> La méthode *__construct()*, appelée lors de l'instanciation de la classe *Kernel*, instancie le *Router*. Cela va permettre de récupérer cette instance dans la méthode *bootstrap*.
> La méthode *bootstrap* crée une nouvelle instance de *AppController*, récupère la méthode à appeler grâce à la méthode *getControllerMethod()* du *Router*, et appelle cette méthode dans le controller.\
> Voici enfin le code de *index.php* :

```php
    <?php require_once CLASSES . 'Kernel.php' ?>

    <?php
    $kernel = new Kernel();
    $kernel->bootstrap();
?>
```

## ETAPE 5 : un peu de config

> On va créer un nouveau fichier *src/config/customConfig.php*.
> On y met les constantes propres à notre application :

```php
<?php

define("HOMEPAGE", "home");

define("NOT_FOUND_ROUTE", "404");

define("TITLE", "Earth");

```

> On intégre ce fichier à *src/config/config.php* :

```php
<?php

define("SRC", "./src/");

define("TEMPLATE", SRC . "template/");

define("TEMPLATE_PARTS", TEMPLATE . "template-parts/");

define("ASSETS", "./public/assets/");

define("FONCTIONS", SRC . "fonctions/");

define("CLASSES", SRC . "classes/");

define("PAGES", TEMPLATE . "pages/");

define("ROUTES", include SRC . 'config/routes.php');

require_once SRC . 'config/customConfig.php';
```

> Cela permet de ne pas s'occuper de la configuration générale (config.php) lorsque nous créerons d'autres applications avec notre structure.

## ETAPE 6 : render()

> Nous pouvons déplacer la logique qui teste si une page existe dans la méthode *render()* de la classe *AppController*.\
> *src/classes/AppController.php*

```php
<?php
require_once CLASSES . 'AbstractController.php';

class AppController
{
    public function __construct()
    {
    }

    public function home()
    {
        $this->render("home");
    }
    public function about()
    {
        $this->render("about");
    }
    public function services()
    {
        $this->render("services");
    }
    public function contact()
    {
        $this->render("contact");
    }
    private function render($page)
    {
        $pagePath = PAGES . $page . ".php"; // le chemin complet de la page
        if (!file_exists($pagePath)) {
            header("location:index.php?page=" . NOT_FOUND_ROUTE); // on redirige vers 404.php
        }

        include TEMPLATE . 'base.php';
    }
}
```

## ETAPE 7 : envoyer des données à la vue (page)

> Souvent, on voudra "envoyer" des données (par exemple issues d'une base de données) dans une page pour que celle-ci puisse les afficher.\
> Pour cela, nous passerons ces donnée sous la forme d'un tableau associatif à la méthode *render*, qui rendra ce tableau disponible dans la vue.

> Dans *AppController* :

```php
private function render($page, $params = null)
{
    $pagePath = PAGES . $page . ".php"; // le chemin complet de la page
    if (!file_exists($pagePath)) {
        header("location:index.php?page=" . NOT_FOUND_ROUTE); // on redirige vers 404.php
    }

    //transforme le tableau $params en variables portant le nom des clés du tableau
    //ces variables sont disponibles dans la vue
    if ($params != null) {
        extract($params);
    }
    include TEMPLATE . 'base.php';
}
```

> Cette méthode peut être *private* car elle est appelée à l'intérieur de la classe *AppController*.

## ETAPE 8 : un peu d'héritage

> La méthode *render* de *AppController* est un peu encombrante. De plus, si nous créeons une nouvelle application, il faudra penser à la coller dans notre controller. Pour rendre cela un peu plus "automatique", nous allons créer une classe "mère" *AbtractController* qui contiendra la méthode *render* et dont notre classe *AppController* héritera.
> Dans *src/classes*, créer un fichier *AbstrctController.php* :

```php
<?php

abstract class AbstractController
{
    public function notFound()
    {
        $this->render("404");
    }
    protected function render($page, $params = null)
    {
        $pagePath = PAGES . $page . ".php"; // le chemin complet de la page
        if (!file_exists($pagePath)) {
            header("location:index.php?page=" . NOT_FOUND_ROUTE); // on redirige vers 404.php
        }
        //transforme le tableau $params en variables portant le nom des clés du tableau
        //ces variables sont disponibles dans la vue
        if ($params != null) {
            extract($params);
        }
        include TEMPLATE . 'base.php';
    }
}
```

> Ne pas oublier de faire hériter notre classe *AppController* de cette classe *AbstractController*.

```php
<?php

require_once CLASSES . 'AbstractController.php';

class AppController extends AbstractController
{
    public function __construct()
    {
    }

    public function home()
    {
        $this->render("home");
    }
    public function about()
    {
        $this->render("about");
    }
    public function services()
    {
        $this->render("services");
    }
    public function contact()
    {
        $this->render("contact");
    }
}
```

## ETAPE 9 : un peu de sécurité

### On ferme !

> Jusqu'à présent, le dossier *src* reste accessible depuis l'extérieur (le navigateur), c'est-à-dire qu'on peut accéder à n'importe quel script de l'application.\
> C'est un problème.
> On peut le gérer facilement avec un fichier .htaccess.
> Dans le dossier *src*, créer un fichier *.htaccess* avec le code suivant :

```apacheconf
Require all denied
```

> A priori, même si on doit permettre les requêtes Http vers le dossier public (pour les balises link), il n'y pas de raison d'en permettre le parcours direct via le navigateur. On va donc empêcher le parcours du dossier *public* avec un fichier *.htaccess* placé dans ce dossier.

```apacheconf
Options -Indexes
```

## ETAPE 10 : on range, encore !

> On souhaite maintenant séparer le code qui constitue la structure de notre application, et qui sera ré-utilisé pour d'autres applications, du code propre à notre application.
> Créons un dossier *vendor* à la racine du projet pour stocker le code commun à toutes les appications.
> Déplaçons le dossier *src/classes* dans le dossier *vendor*. Il nous faut modifier la valeur de la constante *CLASSES* :

```php
define("VENDOR", "./vendor/");
define("CLASSES", VENDOR . "classes/");
```

> On va aussi isoler la partie configuration générale de la partie customConfig.
> Copier le dossier *src/config* dans *vendor*.
> Dans *vendor*, supprimer les fichiers *customConfig.php* et *route.php*.

## ETAPE 11 : les namespaces et l'autoloader

Pour comprendre, faire cet exercice : [Exercice Composer](https://github.com/DFS-1/composer)

Application dans le projet :
> Initialiser composer
> Personnaliser composer.json
> Installer l'autoload
> Ajouter les namespaces dans les classes
> Remplacer tous les *require* par des *use*.
> Ajouter le require de l'autoload dans index.php

- composer.json
  
```json
"autoload": {
    "psr-4": {
        "vendor\\classes\\": "vendor/classes/",
        "App\\": "src/"
    }
},
```

- index.php
  
```php
<?php
require 'vendor/autoload.php';
require_once './vendor/config/config.php';

use vendor\classes\Kernel;

$kernel = new Kernel();
$kernel->bootstrap();
```

## ETAPE 12 : ré-écriture d'urls

> Problématique : on souhaite disposer d'urls de la forme **http://mondomaine/home**
> Nous allons réaliser cela en 2 temps :
> - nous allons modifier les liens du menus
> - nous allons intégrer un fichier *.htaccess* à la racine du projet pour permettre la traduction des urls de le forme **http://mondomaine/home** en **http://mondomaine/index.php?page=home**
> Ainsi, lorsque nous visiterons l'url **http://mondomaine/home**, tout se passera comme si nous visitions **http://mondomaine/index.php?page=home**

### Modification des liens de menu

Dans *src/template/template-parts/_nav.php* :

```html
<nav>
    <div>
        <img src=<?= ASSETS . "./images/logo.png" ?> alt="">
    </div>
    <ul class="visible">
        <li><a href="./home">HOME</a></li>
        <li><a href="./about">ABOUT</a></li>
        <li><a href="./services">SERVICES</a></li>
        <li><a href="./contact">CONTACT</a></li>
    </ul>
    <button id="burger">
        <img class="burgerIcon burgerVisible" src=<?= ASSETS . "./images/burger.svg" ?> width="50" alt="">
        <img class="burgerIcon" src=<?= ASSETS . "./images/burger-cross.svg" ?> width="50" alt="">
    </button>
</nav>
```

- Sur Ubuntu, activer le mode rewrite :

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Puis créer une fichier *.htaccess* à la racine du projet contenant le code :

```apacheconf
# Activer le moteur de réécriture
RewriteEngine On

# Réécriture générique pour toutes les pages
RewriteRule ^([a-zA-Z0-9_-]+)$ index.php?page=$1 [L]
```

# ETAPE 13 : méthode static

> Au lieu d'instancier la classe *Kernel* puis d'appeler la méthode *bootstrap*, on peut appeler directement cette méthode sur la classe *Kernel* :

- index.php

```php
<?php
require 'vendor/autoload.php';
require_once './vendor/config/config.php';

use vendor\classes\Kernel;

Kernel::bootstrap(); // appel static à la méthode bootstrap de la classe Kernel (pas d'instanciation)
```

> Il faut modifier la méthode *bootstrap* en static :

- vendor/classes/Kernel.php

```php
<?php

namespace vendor\classes;

use vendor\classes\Router;
use App\controller\AppController;

class Kernel
{
    public static function bootstrap()
    {
        $router = new Router();
        $controller = new AppController();
        $controllerMethod = $router->getControllerMethod();
        if (method_exists($controller, $controllerMethod)) {
            $controller->$controllerMethod(); //appel de la méthode du controller
        } else {
            $controller->notFound();
        }
    }
}
```
