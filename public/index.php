<?php
require __DIR__.'/../vendor/autoload.php';

use Bilan\Micro\Micro;
use Bilan\Models\User;


$micro = Micro::getInstance();
$micro->bootstrap();

echo "index";
