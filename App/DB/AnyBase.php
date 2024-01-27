<?php
 namespace Bank\App\DB;
 
 use Bank\App\DB\FileBase;
 use Bank\App\DB\MariaBase;
 use Bank\App\SwitchDB;
 use PDO;

 $db = SwitchDB::get()->getDB();

 if($db === 'MariaDB') {
     class AnyBase extends MariaBase {
        private $pdo, $table;
     }

 } else {
     class AnyBase extends FileBase {
        private $file, $data, $index, $save = true;
     }
 }

?>