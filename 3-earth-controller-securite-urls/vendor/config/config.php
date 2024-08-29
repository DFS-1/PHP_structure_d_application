<?php

define("SRC", "./src/");

define("TEMPLATE", SRC . "template/");

define("TEMPLATE_PARTS", "./src/template/template-parts/");

define("ASSETS", "./public/assets/");

define("FONCTIONS", "./src/fonctions/");

define('VENDOR', './vendor/');

define("CLASSES", VENDOR . "classes/");

define("PAGES", "./src/template/pages/");

define("ROUTES", include SRC . 'config/routes.php');

require_once SRC . 'config/customConfig.php';
