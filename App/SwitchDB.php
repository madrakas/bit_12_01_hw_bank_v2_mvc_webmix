<?php

namespace Bank\App;

use Bank\App\App;

class SwitchDB {

    private static $dbSwitch;
    private $db;

    public static function get() {
        return self::$dbSwitch ?? self::$dbSwitch = new self;
    }

    private function __construct() {
        if (isset($_SESSION['db'])) {
            $this->db = $_SESSION['db'];
        } else {
            $configDB = unserialize(file_get_contents(ROOT . '/data/config.ser'))['db'];
            $this->db = $configDB;
        }
    }

    
    public function changeInit()
    {
        $dbs = $this->getAllDBs();
        return App::View('database/utils',[
            'dbs' => $dbs,
            'db' => $this->db
        ]);
    }

    public function changeDB($newDB) {
        $_SESSION['db'] = $newDB;
        $config = unserialize(file_get_contents(ROOT . '/data/config.ser'));
        $config['db'] = $newDB;
        file_put_contents(ROOT . '/data/config.ser', serialize($config));
        $this->db = $configDB;
        App::redirect('database/utilities');
    }

    public function getDB() {
       return $this->db;
    }

    public function getAllDBs() {
        return unserialize(file_get_contents(ROOT . '/data/config.ser'))['dbs'];
    }

    public function reset(){
        $db = 'FileBase';
        $dbs = ['FileBase', 'MariaDB'];
        $config = [
            'db' => $db,
            'dbs' => $dbs
        ];
        file_put_contents(ROOT . '/data/config.ser', serialize($config));
    }
}