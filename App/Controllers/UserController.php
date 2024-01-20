<?php 

namespace Bank\App\Controllers;
use Bank\App\App;
use Bank\App\DB\FileBase;

class UserController {

    public function create () {
        return App::view('users/create');
    }

    public function store($request){
        //Collection
        $firstname = $request['firstname'] ?? null;
        $lastname = $request['lastname'] ?? null;
        $ak = $request['ak'] ?? null;
        $email = $request['email'] ?? null;
        $pw1 = $request['pw1'] ?? null;
        $pw2 = $request['pw2'] ?? null;

        //Validation 

        //Create user
        $writer = new FileBase('users');
        $userID = $writer->create((object) [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'ak' => $ak,
            'email' => $email,
            'pw' => sha1($pw1)
        ]);
        //Create account for a new user
        $writer = new FileBase('accounts');
        $writer->create((object) [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'ak' => $ak,
            'email' => $email,
            'pw' => sha1($pw1)
        ]);
        App::redirect('');
    }
}