<?php require_once './src/config/config.php' ?>
<?php require_once './src/classes/Router.php' ?>

<?php
$router = new Router();
$page = $router->getPage();
$pagePath = $router->getPath();
?>

<?php include TEMPLATE . 'base.php' ?>
