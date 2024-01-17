<?php 
use Bank\App\App;

require '../vendor/autoload.php';

define('ROOT', __DIR__ . '/../');
define('URL', 'http://bitbank.bit');

echo App::run();