<?php
namespace Bank\App\Controllers;
use Bank\App\DB\FileBase;

class TransactionController {
    
    public function new ($transaction) {
        $writer = new FileBase('transactions');
        return $writer->create($transaction);
    }

    public function showAccSent($accountID){
        $reader =  new FileBase('transactions');
        $transactions = $reader->showAll();
        // return $transactions;
        return array_filter($transactions, fn($trans) => $trans['from'] == $accountID );
    }

    public function showAccReceived($accountID){
        $reader =  new FileBase('transactions');
        $transactions = $reader->showAll();
        return array_filter($transactions, fn($trans) => $trans['to'] == $accountID );
    }
}




