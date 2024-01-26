<?php 

namespace Bank\App\Controllers;
use Bank\App\App;
use Bank\App\DB\FileBase;
use Bank\App\Controllers\AccountControler;
use Bank\App\Message;

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
            Message::get()->set('red', $err);
            App::redirect('users/create/');
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

        // Create money account for a new user
        (new AccountController)->store2($userID);
        Message::get()->set('green', 'User created Successfully');
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

    public function logins($userID){
        $reader = new FileBase('logins');
        $logins = $reader->showAll();
        $logins = array_filter($logins, fn($login) => $login['user'] == $userID);
        $reader = new FileBase('users');
        $user = $reader->show($userID);
        return App::view('users/logins', [
            'user' => $user,
            'logins' => $logins
        ]);
        
    }

    public function edit($userID){
        $reader = new FileBase('users');
        $user = $reader->show($userID);
        return App::view('users/edit', [
            'user' => $user
        ]);
    }


    public function editPW($userID){
        return App::view('users/editpw', [
            'userID' => $userID
        ]);
    }

    public function updatePW($request){
        //Collection
        $userID = $request['userID'];
        $pw1 = $request['pw1'] ?? '';
        $pw2 = $request['pw2'] ?? '';

        $err = '';
        if ($pw1 === '' || $pw2 ===''){
            $err = 'All fields required';
        }

        if ($pw1 !== $pw2){
            $err = 'Paswords do not match';
        }

        if ($err !== ''){
            Message::get()->set('red', $err);
            App::redirect('users/editPW/' . $userID);
            die;
        }

        $reader = new FileBase('users');
        $user = $reader->show($userID);
        $user->pw = sha1($pw1);
        $writer = new FileBase('users');
        $writer->update($userID, $user);
        Message::get()->set('green', 'Password updated successfully.');
        App::redirect('users/view/' . $userID);
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
            Message::get()->set('red', $err);
            App::redirect('users/edit/' . $userID);
            die;
        }

        $reader = new FileBase('users');
        $user = $reader->show($userID);
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->ak = $ak;
        $user->email = $email;
        $writer = new FileBase('users');
        $writer->update($userID, $user);
        Message::get()->set('green', 'User updated successfully');
         App::redirect('users/view/' . $userID);
    }

    public function delete($userID){
        //validate accounts
        $accounts = new AccountController;
        $err ='';
        if ($accounts->userAccountsAmount($userID) !== 0){
            $err = "To delete user all acounts balance must be 0";
        }
        if ($err !==''){
            Message::get()->set('red', $err);
            App::redirect('users/view/' . $userID);
            die;
        }
        $reader = new FileBase('users');
        $user = $reader->show($userID);
        
        return App::view('users/delete', [
            'user' => $user
        ]);
        
    }

    public function destroy($request){
        $userID = $request['userID'];
        //validate accounts
        $err='';
        $accounts = (new AccountController)->userAccountsAmount($userID);
        if ($accounts !== 0){
            $err = "To delete user all acounts balance must be 0";
        }
        if ($err !==''){
            Message::get()->set('red', $err);
            App::redirect('users/view/' . $userID);
            die;
        }

        //delete accounts
        (new AccountController)->deleteAccountsByUID($userID);
     
        //delete user
        $writer = new FileBase('users');
        $writer->delete($userID);
        Message::get()->set('green', 'Account deleted successfully.');
        App::redirect('users');
    }


    public function viewProfileByUser($userID){
        $user = (new FileBase('users'))->show($userID);
        return App::view('user/viewprofile', ['user' => $user]);
    }


    public function editProfileByUser($userID){
        $user = (new FileBase('users'))->show($userID);
        return App::view('user/editprofile', ['user' => $user]);
    }

    public function updateProfileByUser($userID, $request){
        $user = (object)[
            'id' => $userID,
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'ak' => $request['ak'],
            'email' => $request['email']
        ];
        $writer = (new FileBase('users'));
        $writer->update($userID, $user);
        Message::get()->set('green', 'Profile updated successfully');
        App::redirect('user/viewprofile');
    }
    
    public function changepwByUser() {
        return App::view('user/changepw', []);
    }

    public function updatepwByUser($userID, $request) {
        $pw1 = $request['pw1'];
        $pw2 = $request['pw2'];
        if ($pw1 !== $pw2) 
        {
            Message::get()->set('red', 'Paswords do not match.');
            App::redirect('user/changepw');
            die;
        }
        $user = (new FileBase('users'))->show($userID);
        $user->pw = sha1($pw1);
        (new FileBase('users'))->update($userID, $user);
        Message::get()->set('green', 'Password changed successfully');
        App::redirect('user/viewprofile');
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