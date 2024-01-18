<?php 

namespace Bank\App\Controllers;
use Bank\App\App;

class UserController {

    public function create () {
        return App::view('users/create');
    }
}