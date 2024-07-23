# STRUCTURE D'APPLICATION #3 - MVC

> !! Avant de faire cet exercice, vous devez avoir fait celui-ci : [2-earth-routing](https://github.com/DFS-1/2-earth-routing) !!

> On s'oriente vers une architecture Model View Controller.\
> En quoi cela consiste-t-il ?\
> Ici, c'est surtout la partie controller qui va nous intéresser.\
> Un controller est une classe dont chacune des méthodes va correspondre à une route.\
> Dans chaque méthode d'un controller, on pourra effectuer un traitement - comme récupérer des données en base de données - puis on appellera la méthode *render()* du controller qui effectuera le rendu (include du template).\
> L'appel à la méthode de controller se fera à partir d'une classe Kernel.

## ETAPE 1 : structure, encore !

### Dossier controller

- Créer un dossier *controller* dans le dossier *src* ainsi que le constante correspondante.
- Dans ce dossier, créer un fichier AppController.php pour la classe AppController

## ETAPE 2 : la classe controller

### Structure et role

- La classe controller (que nous appellerons AppController) contiendra des méthodes appelées en fonction du paramètre d'url *page*.
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
> Ce fichier renvoie un tableau associatif. Chaque clé représente le paramètre d'url *page* et chaque valeur représente la méthode de controller ciblée. Même si ce tableau semble inutile, il assure qu'on ne pourra pas appeler directement toutes les méthodes de *AppController*. En effet, il se peut que certaines de ces méthodes ne correspondent pas à une page. Ici, les valeurs des clés et des valeurs sont les mêmes, mais cela n'est pas forcément le cas. 

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

> La méthode *getControllerMethod()* nous rencoie la méthode de controller à appeler.\
> Nous allons créer une nouvelle classe pour appeler cette méthode, la classe *Kernel*

## ETAPE 4 : la classe kernel

> Pourquoi ?\
> Simplement pour ne pas mettre de la logique dans *index.php*.\
> On regarde.

```php
<?php

require_once './src/classes/Router.php';
require_once './src/controller/AppController.php';

class Kernel
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function bootstrap()
    {
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
> La méthode *bootstrap* crée une nouvelle instance de *AppController*, récupère la méthode à appeler grâce à la méthode *getControllerMethod()* du *Router*, et appelle cette méthode.\
> Voici enfin le code de *index.php* :

```php
    <?php require_once './src/config/config.php' ?>
    <?php require_once './src/classes/Kernel.php' ?>

    <?php
    $kernel = new Kernel();
    $kernel->bootstrap();
?>
```

## ETAPE 5 : le templating => base.php

> Il nous faut déplacer la logique qui teste si une page existe dans le fichier *base.php*.\
> *src/template/base.php*

```php
<!DOCTYPE html>
<html lang="en">

<?php include './src/template/template-parts/_head.php'; ?>

<body>
    <?php
        $pagePath = PAGES . $page . ".php"; // le chemin complet de la page
        if (!file_exists($pagePath)) {
            header("location:index.php?page=" . NOT_FOUND_ROUTE); // on redirige vers 404.php
        }
        include $pagePath;
    ?>

    <?php include TEMPLATE_PARTS . '/_footer.php' ?>
</body>

</html>
```

- On inclut la balise *head*.\
- On teste si le fichier de la page demandée existe. Si non, on redirige vers la page *404*.\
- On inclut la page (balise *header + main*).\
- On inclut le *footer*.

## ETAPE 6 : envoyer des données à la vue (page)

> Souvent, on voudra "envoyer" des données (par exemple issues d'une base de données) dans une page pour que celle-ci puisse les afficher.\
> Pour cela, nous passerons ces donnée sous la forme d'un tableau associatif à la méthode *render*, qui rendra ce tableau disponible dans la vue.

> Dans *AppController* :

```php
private function render($page, $params = null)
    {
        //transforme le tableau $params en variables portant le nom des clés du tableau
        //ces variables sont disponibles dans la vue
        if ($params != null) {
            extract($params);
        }
        include TEMPLATE . 'base.php';
    }
```

> Cette méthode peut être *private* car elle est appelée à l'intérieur de la classe *AppController*.

## ETAPE 7 : un peu de sécurité

### On ferme !

> Jusqu'à présent, le dossier *src* reste accessible depuis l'extérieur (le navigateur), c'est-à-dire qu'on peut accéder à n'importe quel script de l'application.\
> C'est un problème.
> On peut le gérer facilement avec un fichier .htaccess.
> Dans le dossier *src*, créer un fichier *.htaccess* avec le code suivant :

```apacheconf
Deny from all
```

> Dans le même ordre d'idées, on va empêcher le parcours du dossier *public*.
> Créer un fichier *public/.htaccess*, avec le code suivant :

```apacheconf
Options -Indexes
```

## ETAPE 8 : ré-écriture d'urls

> Encore du htaccess !
> ...