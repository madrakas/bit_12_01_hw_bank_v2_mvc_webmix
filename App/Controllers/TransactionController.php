<?php
namespace Bank\App\Controllers;
use Bank\App\DB\FileBase;

class TransactionController {
    
    public function new ($transaction) {
        $writer = new FileBase('transactions');
        return $writer->create($transaction);
    }

}



