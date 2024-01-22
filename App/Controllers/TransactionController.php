<?php
namespace Bank\App\Controllers;
use Bank\App\App;
use Bank\App\DB\FileBase;

class TransactionController {
    
    public function new ($transaction) {
        $writer = new FileBase('transactions');
        return $writer->create($transaction);
    }

    public function showAccSent($accountID){
        $reader =  new FileBase('transactions');
        $transactions = $reader->showAll();
        return array_filter($transactions, fn($trans) => $trans['from'] == $accountID );
    }

    public function showAccReceived($accountID){
        $reader =  new FileBase('transactions');
        $transactions = $reader->showAll();
        return array_filter($transactions, fn($trans) => $trans['to'] == $accountID );
    }

    public function viewLogs(){
        $transactions = (new FileBase('transactions'))->showAll();
        return App::view('transactions/all', [
            'transactions' => $transactions
        ]);
    }

    // public function viewUserLogs($userID){
    //     $transactions = (new FileBase('transactions'))->showAll();
    //     $transactionsFrom = array_filter($transactions, fn($transaction) => $transaction['from'] === $userID);
    //     return App::view('transactions/all', [
    //         'transactions' => $transactions
    //     ]);
    // }

 
}


