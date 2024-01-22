<?php

namespace Bank\App;

use Bank\App\Controllers\HomeController;
use Bank\App\Controllers\UserController;
use Bank\App\Controllers\AccountController;
use Bank\App\Controllers\LoginController;
use Bank\App\Controllers\TransactionController;
use Bank\App\Message;
use Bank\App\Auth;

class App{

    public static function run(){
        $server = $_SERVER['REQUEST_URI'];
        $url = explode('/', $server);
        array_shift($url);
        return self::router($url);
    }

    private static function router($url){
        $method = $_SERVER['REQUEST_METHOD'];

        if ('GET' === $method && count($url) === 1 && $url[0] === ''){
            return(new HomeController)->index('blue');
        }

        if ('GET' == $method && count($url) == 1 && $url[0] == 'login') {
            return (new LoginController)->index();
        }

        if ('POST' == $method && count($url) == 1 && $url[0] == 'login') {
            return (new LoginController)->login($_POST);
        }

        if ('POST' == $method && count($url) == 1 && $url[0] == 'logout') {
            return (new LoginController)->logout();
        }

        if ('GET' === $method && count($url) === 2 && $url[0] === 'home'){
            return(new HomeController)->index($url[1]);
        }

        if ($url[0] == 'users' && Auth::get()->getStatus() !==1) {
            return self::redirect('');
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

        if ('GET' === $method && count($url) === 3 && $url[0] === 'users' && $url[1] === 'logins'){
            return(new UserController)->logins($url[2]);
        }

        if ($url[0] == 'accounts' && Auth::get()->getStatus() !==1) {
            return self::redirect('');
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'accounts' && $url[1] === 'create'){
            return(new AccountController)->create($url[2]);
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'accounts' && $url[1] === 'view'){
            return(new AccountController)->viewTransactions($url[2]);
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

        if ('GET' === $method && count($url) === 3 && $url[0] === 'accounts' && $url[1] === 'addfunds'){
            return(new AccountController)->addfunds($url[2]);
        }

        if ('GET' === $method && count($url) === 3 && $url[0] === 'accounts' && $url[1] === 'remfunds'){
            return(new AccountController)->remfunds($url[2]);
        }

        if ('POST' === $method && count($url) === 2 && $url[0] === 'accounts' && $url[1] === 'updateamount'){
            return (new AccountController)->updateamount($_POST);
        }

        if ($url[0] == 'logins' && Auth::get()->getStatus() !==1) {
            return self::redirect('');
        }

        if ('GET' === $method && count($url) === 2 && $url[0] === 'logins' && $url[1] === 'all'){
            return(new LoginController)->viewLogs();
        }

        if ($url[0] == 'transactions' && Auth::get()->getStatus() !==1) {
            return self::redirect('');
        }

        if ('GET' === $method && count($url) === 2 && $url[0] === 'transactions' && $url[1] === 'all'){
            return(new TransactionController)->viewLogs();
        }

        if ($url[0] == 'user' && !Auth::get()->getStatus()) {
            return self::redirect('');
        }    
        
        if ('GET' === $method && count($url) === 2 && $url[0] === 'user' && $url[1] === 'accounts'){
            return(new AccountController)->viewByUser(Auth::get()->getStatus());
        }

        if ('GET' === $method && count($url) === 2 && $url[0] === 'user' && $url[1] === 'addaccount'){
            return(new AccountController)->createByUser(Auth::get()->getStatus());
        }

        if ('POST' === $method && count($url) === 2 && $url[0] === 'user' && $url[1] === 'storeaccount'){
            return (new AccountController)->storeByUser(Auth::get()->getStatus());
        }

        return '<h1>404</h1>';
    }

    public static function view($view, $data = [])
    {
        extract($data);
        $msg = Message::get()->show();
        $auth = Auth::get()->getStatus();
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