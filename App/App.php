<?php

namespace Bank\App;

use Bank\App\Controllers\HomeController;
use Bank\App\Controllers\UserController;

class App{

    public static function run(){
        $server = $_SERVER['REQUEST_URI'];
        $url = explode('/', $server);
        array_shift($url);

        // echo "<h1>Bank is Online<h1>";
        return self::router($url);
    }

    private static function router($url){
        $method = $_SERVER['REQUEST_METHOD'];

        if ('GET' === $method && count($url) === 1 && $url[0] === ''){
            return(new HomeController)->index('blue');
        }

        if ('GET' === $method && count($url) === 2 && $url[0] === 'home'){
            return(new HomeController)->index($url[1]);
        }

        if ('GET' === $method && count($url) === 2 && $url[0] === 'user' && $url[1] === 'create'){
            return(new UserController)->create();
        }

        return '<h1>404</h1>';
    }

    public static function view($view, $data = [])
    {
        extract($data);
        ob_start();
        require ROOT . 'views/top.php';
        require ROOT . "views/$view.php";
        require ROOT . 'views/bottom.php';
        $content = ob_get_clean();
        return $content;
    }
}