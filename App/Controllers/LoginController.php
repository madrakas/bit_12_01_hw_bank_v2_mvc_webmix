<?php

namespace Bank\App\Controllers;

use Bank\App\App;
use Bank\App\Auth;
use Bank\App\Message;

class LoginController {


    public function index() {
        return App::view('auth/login');
    }

    public function login($request) {
        $email = $request['email'] ?? '';
        $password = $request['pw'] ?? '';

        if (Auth::get()->tryLoginUser($email, $password)) {
            Message::get()->set('green', 'You are logged in');
            return App::redirect('');
        }
        
        Message::get()->set('blue', $password);
        Message::get()->set('red', 'Wrong email or password');
        return App::redirect('login');
    }

    public function logout() {
        Auth::get()->logout();
        Message::get()->set('green', 'You are logged out');
        return App::redirect('login');
    }

}