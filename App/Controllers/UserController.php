<?php 

namespace Bank\App\Controllers;
use Bank\App\App;
use Bank\App\DB\FileBase;
use Bank\App\Controllers\AccountControler;

class UserController {
    
    public function index(){
        $reader = new Filebase('users');
        $users = $reader->showAll();
        return App::view('users/index', [
            'users' => $users
        ]);
    }

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
        $err = $this->validUserData($firstname, $lastname, $ak, $email, $pw1, $pw2);
        if ($err !== ''){
            echo $err;
            // App::redirect('users/create/');
            die;
        }

        //Create user
        $writer = new FileBase('users');
        $userID = $writer->create((object) [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'ak' => $ak,
            'email' => $email,
            'pw' => sha1($pw1)
        ]);
        //Create money account for a new user
        // Need to move to accounts controller
        $writer = new FileBase('accounts');
        $writer->create((object) [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'ak' => $ak,
            'email' => $email,
            'pw' => sha1($pw1)
        ]);
        App::redirect('users');
    }

    public function view($userID){
        $reader = new FileBase('users');
        $user = $reader->show($userID);
        $reader = new AccountController;
        $accounts = $reader->view($userID);
        return App::view('users/view', [
            'user' => $user,
            'accounts' => $accounts
        ]);
    }

    public function edit($userID){
        $reader = new FileBase('users');
        $user = $reader->show($userID);
        return App::view('users/edit', [
            'user' => $user
        ]);
    }

    public function update($userID, $request){
        //Collection
        $firstname = $request['firstname'] ?? null;
        $lastname = $request['lastname'] ?? null;
        $ak = $request['ak'] ?? null;
        $email = $request['email'] ?? null;
        
        //validation
        $err = $this->validUserData2($firstname, $lastname, $ak, $email);
        if ($err !==''){
            echo $err;
            // App::redirect('users/edit/' .userid);
            die;
        }

        $writer = new FileBase('users');
        $writer->update($userID, (object) [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'ak' => $ak,
            'email' => $email,
            'pw' => sha1($pw1)
        ]);
        App::redirect('users/view/' . $userID);
    }

    public function delete($userID){
        $reader = new FileBase('users');
        $user = $reader->show($userID);
        return App::view('users/delete', [
            'user' => $user
        ]);
        
    }

    public function destroy($request){
        $userID = $request['userID'];
        //validate accounts
        //delete
        $writer = new FileBase('users');
        $writer->delete($userID);
        App::redirect('users');
    }

    
    //Validations
    private function validUserData($firstname, $lastname, $ak, $email, $pw1, $pw2) : string
    {
        $err = '';

        if ($firstname === '' || $lastname === '' || $ak === '' || $email === '' || $pw1 === '' || $pw2 === ''){
            $err .= 'All fields are required.<br/>';
        }elseif ($pw1 !== $pw2) {
            $err .= 'Passwords do not match.<br/>';
        } elseif(!$this->validPersonalCode($ak)){
            $err .= 'Invalid Personal identification number.<br/>';
        } elseif ($this->emailExists($email)) {
            $err .= 'User with same Email already exists.<b/r>.';
        } elseif ($this->akExists($ak)){
            $err .= 'User with same Personal identification number already exists.<b/r>';
        } elseif (strlen($firstname) < 4){
            $err .= 'First name must be 4 letters or longer';
        } elseif (strlen($lastname) < 4){
            $err .= 'Last name must be 4 letters or longer';
        }
    
        return $err;
    }

    private function validUserData2($firstname, $lastname, $ak, $email) : string
    {
        $err = '';

        if ($firstname === '' || $lastname === '' || $ak === '' || $email === ''){
            $err .= 'All fields are required.<br/>';
        } elseif(!$this->validPersonalCode($ak)){
            $err .= 'Invalid Personal identification number.<br/>';
        } elseif (strlen($firstname) < 4){
            $err .= 'First name must be 4 letters or longer';
        } elseif (strlen($lastname) < 4){
            $err .= 'Last name must be 4 letters or longer';
        }
    
        return $err;
    }

    private function validPersonalCode($code) : bool
    {
        if (strlen($code) === 11) {
            if ($code[0] >= 1 && $code[0] <= 6) {
                if (checkdate(substr($code, 3, 2), substr($code, 5, 2), substr($code, 1, 2))) {
                    $s = $code[0] * 1 + $code[1] * 2 + $code[2] * 3 + $code[3] * 4 + $code[4] * 5 + $code[5] * 6 + $code[6] * 7 + $code[7] * 8 + $code[8] * 9 + $code[9] * 1;
                    if ($s % 11 === 10) {
                        $s = $code[0] * 3 + $code[1] * 4 + $code[2] * 5 + $code[3] * 6 + $code[4] * 7 + $code[5] * 8 + $code[6] * 9 + $code[7] * 1 + $code[8] * 2 + $code[9] * 3;
                        if ($s % 11 === 10 && $s % 11 == $code[10]) {
                            return true;
                        } elseif ($s % 11 == $code[10]) {
                            return true;
                        }
                    } elseif ($s % 11 == $code[10]) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function emailExists($email) : bool{
        $counter = new FileBase('users');
        $count = $counter-> count('email', $email);
        if ($count > 0){
            return true;
        }
        return false;
    }

    private function akExists($ak) : bool{
        $counter = new FileBase('users');
        $count = $counter-> count('ak', $ak);
        if ($count > 0){
            return true;
        }
        return false;
    }
}