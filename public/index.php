<?php 
use Bank\App\App;
use Bank\App\Message;
use bank\App\Auth;

session_start();
require '../vendor/autoload.php';

define('ROOT', __DIR__ . '/../');
define('URL', 'http://bitbank.bit');
// define('DB', 'MariaDB');
define('DB', 'FileBase');
echo App::run();