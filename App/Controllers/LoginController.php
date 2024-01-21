<?php

namespace Bank\App\Controllers;

use Bank\App\App;
use Bank\App\Auth;
use Bank\App\Message;
use Bank\App\DB\FileBase;

class LoginController {


    public function index() {
        return App::view('auth/login');
    }

    public function login($request) {
        $email = $request['email'] ?? '';
        $password = $request['pw'] ?? '';
        if (Auth::get()->tryLoginUser($email, $password)) {
            (new FileBase('logins'))->create((object)[
                'time' => date('Y-m-d H:i:s'),
                'user' => $_SESSION['user'],
                'status' => 'Login ok',
            ]);
            Message::get()->set('green', 'You are logged in');
            return App::redirect('');
        }
        
        (new FileBase('logins'))->create((object)[
            'time' => date('Y-m-d H:i:s'),
            'user' => Auth::get()->getStatus(),
            'status' => 'Login failed',
        ]);
        Message::get()->set('red', 'Wrong email or password');
        return App::redirect('login');
    }

    public function logout() {
        Auth::get()->logout();
        (new FileBase('logins'))->create((object)[
            'time' => date('Y-m-d H:i:s'),
            'user' => Auth::get()->getStatus(),
            'status' => 'Logout ok',
        ]);
        Message::get()->set('green', 'You are logged out');
        return App::redirect('login');
    }

}