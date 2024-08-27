<?php
require_once './src/config/config.php';
require_once CLASSES . 'Kernel.php';

$kernel = new Kernel();
$kernel->bootstrap();
