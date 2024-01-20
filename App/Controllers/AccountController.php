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

    public function delete($accountID){
        $reader = new FileBase('accounts');
        $account = $reader->show($accountID);
        if ($account->amount !== 0){
            $uid = $account->uid;
            $err = 'Cannot delete. Account not empty';
            App::view('users/view/' . $uid);
        }else{
            return App::view('accounts/delete', [
                'account' => $account
            ]);
        }
    }

    public function destroy($request){
        $accountID = $request['accountID'];
        $reader = new FileBase('accounts');
        $account = $reader->show($accountID);
        $userID = $account->uid;
        if ($account->amount !== 0){
            $err = 'Cannot delete. Account not empty';
            App::redirect('users/view/' . $uid);
        }
        $writer = new FileBase('accounts');
        $writer->delete($accountID);
        App::redirect('users/view/' . $userID);
    }

    public function addfunds($accountID){
        $reader = new FileBase('accounts');
        $account = $reader->show($accountID);

        return App::View('accounts/addfunds', [
            'accountID' => $accountID,
            'account' => $account
        ]);
    }

    public function remfunds($accountID){
        $reader = new FileBase('accounts');
        $account = $reader->show($accountID);

        return App::View('accounts/remfunds', [
            'accountID' => $accountID,
            'account' => $account
        ]);
    }

    public function updateAmount($request){
        $accountID = $request['accountID'];
        $addAmount = $request['addAmount'] ?? 0;
        $remAmount = $request['remAmount'] ?? 0;

        $reader = new filebase('accounts');
        $account = $reader->show($accountID);
        $userID = $account->uid;
        $account->amount += $addAmount;
        $account->amount -= $remAmount;
        $writer = new filebase('accounts');
        $writer->update($accountID, $account);

        App::redirect('users/view/' . $userID);
    }
}