# STRUCTURE D'APPLICATION #2 - ROUTING

> !! Avant de faire cet exercice, vous devez avoir fait celui-ci : [1-earth-dry](https://github.com/DFS-1/PHP-DRY-Earth) !!

## ETAPE 1 : structure, encore !

### Dossiers fonctions et classes

- Créer un dossier *fonctions* et un dossier *classes* dans le dossier *src* ainsi que les constantes correspondantes.

## ETAPE 2 : Un seul point d'entrée

### Structure des urls

  On souhaite dans un premier temps avoir des urls de la forme : *index.php?page=nom_de_la_page*.\
  Le paramètre *page* peut être récupéré via la superglobale *$_GET["page"]*.

- Modifier tous les liens de menu (*src/template/template_parts/_nav.php* et *src/template/template_parts/_footer.php*) :

```html
<nav>
    <div>
        <img src=<?= ASSETS . "./images/logo.png" ?> alt="">
    </div>
    <ul class="visible">
        <li><a href="./index.php?page=home">HOME</a></li>
        <li><a href="./index.php?page=about">ABOUT</a></li>
        <li><a href="./index.php?page=services">SERVICES</a></li>
        <li><a href="./index.php?page=contact">CONTACT</a></li>
    </ul>
    <button id="burger">
        <img class="burgerIcon burgerVisible" src=<?= ASSETS . "./images/burger.svg" ?> width="50" alt="">
        <img class="burgerIcon" src=<?= ASSETS . "./images/burger-cross.svg" ?> width="50" alt="">
    </button>
</nav>
```

### La balise head

- Déplacer la balise head dans un fichier séparé *src/template/template-parts/_head.php*
- Inclure ce fichier à la place de la balise head.

```php
    <?php
        include './src/template/template-parts/_head.php'
    ?>
```

> Problème avec le css car toutes les pages ont maintenant la même balise link.
> On va donc rendre le chemin du fichier CSS dynamique, en fonction du paramètre page de l'url.

- Dans *index.php* :

```php
    <?php
    $page = "home"; // valeur par défaut
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } 
    include './src/template/template-parts/_head.php'
    ?>
```

- Dans *_head.php*, on intègre la variable *$page* dans le chemin du fichier *index.css* :

```html
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <link rel="stylesheet" href=<?= ASSETS . "./css/$page/index.css" ?> >
    <script defer src=<?= ASSETS . "./js/main.js" ?>></script>
</head>
```

### Création des pages

- Créer un fichier *home.php* à la racine du projet
- Placer le contenu de la balise body de *index.php* dans le fichier *home.php*
- Dans index.php, insérer le code suivant :

```php
    <?php
        include $_GET["page"] . ".php";
    ?>
```

- Tester l'url *index.php?page=home*
- Ok, c'est bien, mais il faut tester si le fichier à insérer (*home.php*) existe bien :

```php
    <?php
        if (file_exists($_GET["page"] . ".php")) {
            include $_GET["page"] . ".php";
        } else {
            include "404.php";
        }
    ?>
```



- Créer le fichier 404.php

```php
<?php require_once './src/config/config.php' ?>

<!DOCTYPE html>
<html lang="en">

<?php include './src/template/template-parts/_head.php' ?>

<body>
    <header>
        <?php include TEMPLATE_PARTS . '/_nav.php' ?>
        <h1>Oups</h1>
        <p>NOT FOUND</p>
    </header>
    <?php include TEMPLATE_PARTS . '/_footer.php' ?>
</body>

</html>
```

> Et s'il n'y a pas de paramètre *page* dans l'url => home ?

- Tester la présence du paramètre *page=* :

```php
    <?php
        if (isset($_GET["page"])) {
            if (file_exists($_GET["page"] . ".php")) {
                include $_GET["page"] . ".php";
            } else {
                include "404.php";
            }
        } else {
            include "home.php";
        }
    ?>
```

- Généraliser ce qu'on a fait pour *home.php* aux autres pages.

## ETAPE 3 : on range

### Les pages

- Créer un dossier *src/template/pages*
- Déplacer les fichiers *home.php, about.php, services.php, contact.php, 404.php* dans ce dossier
- Créer une constante *PAGES* pour le chemin *src/template/pages*
- Dans *index.php*, modifier le chemin du fichier à inclure en utilisant la constante *PAGES* :

```php
<body>
    <?php
    if (isset($_GET["page"])) {
        if (file_exists(PAGES . "/" . $_GET["page"] . ".php")) {
            include PAGES . "/" . $_GET["page"] . ".php";
        } else {
            include PAGES . "/" . "404.php";
        }
    } else {
        include PAGES . "/" . "home.php";
    }
    ?>
</body>
```

> Et voilà, nous n'avons plus que le fichier *index.php* comme point d'entrée à la racine du projet !
> Bon, on a fini alors ?
> Ben...non.

## ETAPE 4 : on route pour de bon

### Refactoring et optimisation

> On repart avec le code suivant pour index.php :

```php
<?php require_once './src/config/config.php' ?>

<!DOCTYPE html>
<html lang="en">

<?php
$page = "home"; // valeur par défaut
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
?>
<?php include './src/template/template-parts/_head.php'; ?>

<body>
    <?php
    $pagePath = PAGES . "/" . $page . ".php"; // le chemin complet de la page
    if (file_exists($pagePath)) {
        include $pagePath;
    } else {
        header("location:index.php?page=404"); // on redirige vers 404.php
    }
    ?>

    <?php include TEMPLATE_PARTS . '/_footer.php' ?>

</body>

</html>
```

> On souhaite maintenant déplacer la partie templating dans le dossier *src/template* pour ne garder que de la logique (du php) dans *index.php*.

- Créer un fichier *src/template/base.php*.
- Créer une constante *TEMPLATE* pour le dossier *src/template/*.
- Dans *base.php*, coller le code suivant :

```php
<!DOCTYPE html>
<html lang="en">

<?php include './src/template/template-parts/_head.php'; ?>

<body>
    <?php include $pagePath; ?>

    <?php include TEMPLATE_PARTS . '/_footer.php' ?>
</body>

</html>
```

- Le code de *index.php* devient :

```php
<?php require_once './src/config/config.php' ?>

<?php
$page = "home"; // valeur par défaut
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
$pagePath = PAGES . $page . ".php"; // le chemin complet de la page
if (!file_exists($pagePath)) {
    header("location:index.php?page=404"); // on redirige vers 404.php
}
?>

<?php include TEMPLATE . 'base.php' ?>
```

> Pfiou !!

> Bon, on fait le point :\
> On a dans *index.php* la logique qui permet de déterminer quelle page afficher ainsi que la valeur de la variable *$page* qui nous sert à intégrer le bon code CSS.\
> Ce fichier *index.php* inclut le fichier *src/template/base.php*.\
> Le fichier *src/template/base.php* contient l'affichage de la page.

### Un router, enfin !

> On souhaite implémenter la fonctionnalité de routing avec une classe dédiée.\
> Comment penser cela ?\
> Pour implémenter une fonctionnalité en Programmation Orientée Objet, il faut se demander ce que doit faire la classe (les méthodes) et avec quoi (les propriétés).\
> Dans le cas de notre routeur, celui-ci doit nous générer le chemin du fichier de la page à afficher connaissant le paramètre d'url *page=*.\
> Donc, on va créer une classe Router qui aura pour propriété le paramètre d'url *page* et une méthode *getPath()* qui renverra le chemin de la page.\
> On essaie...

- La classe : créer un fichier *Router.php* (oui, avec une majuscule au début) dans le dossier *src/classes*.

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

> Notez que nous avons typé la propriété *$page* ainsi que les retours des méthodes.

- index.php :

```php
<?php require_once './src/config/config.php' ?>
<?php require_once './src/classes/Router.php' ?>

<?php
$router = new Router();
$page = $router->getPage();
$pagePath = $router->getPath();
?>

<?php include TEMPLATE . 'base.php' ?>
```

> Hola ! ça pique là ! ça a tout changé !\
> Ok. Il n'y a pas vraiment de code en plus, il est simplement ordonné différemment.\
> Explications :
> - Dans *Router.php*, la propriété *page* est de type *string*. Bon.\
> - Le constructeur (*public function __construct()*), appelé lors de l'instanciation de la classe (*new Router()*), détermine la valeur de la propriété *page* (*this->page*).\
> Une fois la classe instanciée (*new Router()*), on récupère la valeur de la propriété *page* avec la méthode *getPage()*.\
> - Enfin, la méthode *getPath()* nous renvoie le chemin du fichier à inclure dans *base.php*.\
> - C'est juste une logique différente, mais d'un point de vue fonctionnel, ça fait la même chose qu'avant.

> Bon, on arrête là pour cette partie.\
> Si tu es arrivé jusque là, bravo, ça n'est pas évident...\
> La suite ? Un controller, un peu de sécurité...
