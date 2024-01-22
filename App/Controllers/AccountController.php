<?php
namespace Bank\App\Controllers;

use Bank\App\App;
use Bank\App\DB\FileBase;
use Bank\App\Controllers\TransactionController;
use Bank\App\Message;

class AccountController {
    
    public function create ($userID) {
        return App::view('accounts/create', [
            'uid' => $userID
        ]);
    }

    public function createByUser ($userID) {
        return App::view('user/createaccount', [
            'uid' => $userID
        ]);
    }

    public function store ($request) {
        $userID = $request['uid'];
        $writer = new FileBase('accounts');
        $accountID = $writer->nextID();
        $iban = 'LT' . rand(0, 9) . rand(0, 9) . '99999' . str_pad($accountID, 10, '0', STR_PAD_LEFT);
        $writer->create((object)[
            'uid' => intval($userID),
            'iban' => $iban,
            'amount' => 0,
            'currency' => 'Eur'
        ]);
        Message::get()->set('green', 'Account created Successfully');
        App::redirect('users/view/' . $userID);
    }

    public function storeByUser ($userID) {
        $writer = new FileBase('accounts');
        $accountID = $writer->nextID();
        $iban = 'LT' . rand(0, 9) . rand(0, 9) . '99999' . str_pad($accountID, 10, '0', STR_PAD_LEFT);
        $writer->create((object)[
            'uid' => intval($userID),
            'iban' => $iban,
            'amount' => 0,
            'currency' => 'Eur'
        ]);
        Message::get()->set('green', 'Account created Successfully');
        App::redirect('user/accounts');
    }

    public function store2 ($userID) {
        $writer = new FileBase('accounts');
        $accountID = $writer->nextID();
        $iban = 'LT' . rand(0, 9) . rand(0, 9) . '99999' . str_pad($accountID, 10, '0', STR_PAD_LEFT);
        $writer->create((object)[
            'uid' => intval($userID),
            'iban' => $iban,
            'amount' => 0,
            'currency' => 'Eur'
        ]);
    }

    public function view($userID){
        $reader = new FileBase('accounts');
        $accounts = $reader->showAll();
        $accounts = array_filter($accounts, fn($acc) => $acc['uid'] == $userID);
        return $accounts;
    }

    public function viewByUser($userID){
        $reader = new FileBase('accounts');
        $accounts = $reader->showAll();
        $accounts = array_filter($accounts, fn($acc) => $acc['uid'] == $userID);
        return App::view('user/accounts', [
            'accounts' => $accounts
        ]);
    }

    public function delete($accountID){
        $reader = new FileBase('accounts');
        $account = $reader->show($accountID);
        if ($account->amount !== 0){
            $uid = $account->uid;
            $err = 'Cannot delete. Account not empty';
            Message::get()->set('red', $err);
            App::redirect('users/view/' . $uid);
        }else{
            return App::view('accounts/delete', [
                'account' => $account
            ]);
        }
    }

    public function deleteByUser($userID, $accountID){
        $reader = new FileBase('accounts');
        $account = $reader->show($accountID);
        if ($account->uid !== $userID){
            Message::get()->set('red', 'Account not found');
            App::redirect('user/accounts');
            die;
        }
        if ($account->amount !== 0){
            $uid = $account->uid;
            $err = 'Cannot delete. Account not empty';
            Message::get()->set('red', $err);
            App::redirect('users/accounts/' . $uid);
            die;
        }else{
            return App::view('user/deleteaccount', [
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
            Message::get()->set('red', $err);
            App::redirect('users/view/' . $uid);
        }
        $writer = new FileBase('accounts');
        $writer->delete($accountID);
        Message::get()->set('green', 'Account deleted Successfully');
        App::redirect('users/view/' . $userID);
    }


    public function destroyByUser($userID, $request){
        $accountID = $request['accountID'];
        $reader = new FileBase('accounts');
        $account = $reader->show($accountID);

        if ($account->uid !== $userID){
            Message::get()->set('red', 'Account not found');
            App::redirect('user/accounts');
            die;
        }
        
        $userID = $account->uid;
        if ($account->amount !== 0){
            Message::get()->set('red', 'Cannot delete. Account not empty');
            App::redirect('user/accounts');
        }
        $writer = new FileBase('accounts');
        $writer->delete($accountID);
        Message::get()->set('green', 'Account deleted Successfully');
        App::redirect('user/accounts');
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
        $err ='';
        $account->amount += $addAmount;
        if ($account->amount < $remAmount){
            $err = 'Insuficient banlance.';
        }else{
            $account->amount -= $remAmount;
        }
        if ($err ==='') {
            $writer = new filebase('accounts');
            $writer->update($accountID, $account);

            //log transaction 
            if ($addAmount > 0){
                $transaction = (object) [
                    'time' => date('Y-m-d H:i:s'),
                    'from' => 0,
                    'to'  => $account->id,
                    'toIBAN' => $account->iban,
                    'fromIBAN' => 'cash',
                    'fromName' => '',
                    'toName' => '', 
                    'amount' => $addAmount,
                    'curr' => 'Eur'
                ];
                (new TransactionController)->new($transaction);
                Message::get()->set('green', 'Successfully added ' . $addAmount . ' Eur to ' . $account->iban);
            }elseif($remAmount > 0){
                $transaction = (object) [
                    'time' => date('Y-m-d H:i:s'),
                    'from' => $account->id,
                    'to'  => 0,
                    'toIBAN' => 'cash',
                    'fromIBAN' => $account->iban,
                    'fromName' => '',
                    'toName' => '', 
                    'amount' => $remAmount,
                    'curr' => 'Eur'
                ];
                (new TransactionController)->new($transaction);
                Message::get()->set('green', 'Successfully withdrawed ' . $remAmount . ' Eur from ' . $account->iban);
            }
        }else{
            Message::get()->set('red', $err);
        }
        App::redirect('users/view/' . $userID);
    }


    public function userAccountsAmount($userID){
        $reader = new FileBase('accounts');
        $accounts = $reader->showAll();
        $accounts = array_filter($accounts, fn($acc) => $acc['uid'] == $userID);
        $amount = 0;
        foreach ($accounts as $acc) {
            $amount += $acc['amount'];    
        }
        return $amount;
    }

    public function userAccountsCount($userID){
        $reader = new FileBase('accounts');
        $accounts = $reader->showAll();
        $accounts = array_filter($accounts, fn($acc) => $acc['uid'] == $userID);
        return count($accounts);
    }

    public function deleteAccountsByUID($userID){
        $reader = new FileBase('accounts');
        $accounts = $reader->showAll();
        $accounts = array_filter($accounts, fn($acc) => $acc['uid'] == $userID);
        $writer = new FileBase('accounts');
        foreach ($accounts as $acc) {
            $writer->delete($acc['id']);
        }
      }


    public function viewTransactions($accountID){

        $sent = (new transactionController)->showAccSent($accountID);
        $received = (new transactionController)->showAccReceived($accountID);
        $account = (new FileBase('accounts'))->show($accountID);

        return App::view('accounts/transactions', [
            'accountID' => $accountID,
            'iban' => $account->iban,
            'sent' => $sent,
            'received' => $received
        ]);
    }
}