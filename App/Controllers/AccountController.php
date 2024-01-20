<?php
namespace Bank\App\Controllers;

use Bank\App\App;
use Bank\App\DB\FileBase;

class AccountController {
    
    public function create ($userID) {
        return App::view('accounts/create', [
            'uid' => $userID
        ]);
    }

    public function store ($request) {
        $userID = $request['uid'];
        $writer = new FileBase('accounts');
        $accountID = $writer->nextID();
        $iban = 'LT' . rand(0, 9) . rand(0, 9) . '99999' . str_pad($accountID, 10, '0', STR_PAD_LEFT);
        $writer->create((object)[
            'uid' => $userID,
            'iban' => $iban,
            'amount' => 0,
            'currency' => 'Eur'
        ]);
        App::redirect('users/view/' . $userID);
    }

    public function view($userID){
        $reader = new FileBase('accounts');
        $accounts = $reader->showAll();
        $accounts = array_filter($accounts, fn($acc) => $acc['uid'] === $userID);
        return $accounts;
    }

    

}