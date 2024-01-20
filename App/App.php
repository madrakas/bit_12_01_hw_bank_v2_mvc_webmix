<?php

namespace Bank\App;

use Bank\App\Controllers\HomeController;
use Bank\App\Controllers\UserController;
use Bank\App\Controllers\AccountController;

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

        if ('GET' === $method && count($url) === 1 && $url[0] === 'users'){
            return(new UserController)->index();
        }

        if ('GET' === $method && count($url) === 2 && $url[0] === 'users' && $url[1] === 'create'){
            return(new UserController)->create();
        }

        if ('POST' === $method && count($url) === 2 && $url[0] === 'users' && $url[1] === 'store'){
            return (new UserController)->store($_POST);
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'users' && $url[1] === 'view'){
            return(new UserController)->view($url[2]);
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'users' && $url[1] === 'edit'){
            return(new UserController)->edit($url[2]);
        }

        if ('POST' === $method && count($url) === 3 && $url[0] === 'users' && $url[1] === 'update'){
            return (new UserController)->update($url[2], $_POST);
        }
        
        if ('GET' === $method && count($url) === 3 && $url[0] === 'users' && $url[1] === 'editpw'){
            return(new UserController)->editPW($url[2]);
        }
        
        if ('POST' === $method && count($url) === 3 && $url[0] === 'users' && $url[1] === 'updatepw'){
            return (new UserController)->updatePW($_POST);
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'users' && $url[1] === 'delete'){
            return(new UserController)->delete($url[2]);
        }

        if ('POST' === $method && count($url) === 2 && $url[0] === 'users' && $url[1] === 'destroy'){
            return (new UserController)->destroy($_POST);
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'accounts' && $url[1] === 'create'){
            return(new AccountController)->create($url[2]);
        }

        if ('POST' === $method && count($url) === 2 && $url[0] === 'accounts' && $url[1] === 'store'){
            return (new AccountController)->store($_POST);
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'accounts' && $url[1] === 'delete'){
            return(new AccountController)->delete($url[2]);
        }

        if ('POST' === $method && count($url) === 2 && $url[0] === 'accounts' && $url[1] === 'destroy'){
            return (new AccountController)->destroy($_POST);
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

    public static function redirect($url)
    {
        header('Location: ' . URL . '/' . $url);
        return null;
    }
}