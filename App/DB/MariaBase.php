<?php
namespace Bank\App\DB;

use App\DB\DataBase;
use PDO;

class MariaBase implements DataBase
{
    private $pdo, $table;

    public function __construct($table)
    {
        $host = 'localhost';
        $db   = 'bitbank';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $options);
        $this->table = $table;
    }

    public function create(object $data) : int{

        $keys = array_keys((array)$data);
        $keys = array_map(fn($key) => "`". $key . "`", $keys);
        $keys = implode(', ', $keys);
        $values = array_values((array)$data);
        $placeholder = implode(', ', array_map(fn($v) => '?', $values));
    
        $sql = "
            INSERT INTO {$this->table} (" . $keys . ")
            VALUES (" . $placeholder . ")
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $this->pdo->lastInsertId();
    }

    public function update(int $id, object $data) : bool
    {
        $keys = array_keys((array)$data);
        $keys = array_map(fn($key)=> $key .' = ?', $keys);
        $keys = implode(', ', $keys);

        $values = array_values((array)$data);
        array_push($values, $id);

        $sql = "
            UPDATE {$this->table}
            SET " . $keys . "
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete(int $id) : bool
    {
        $sql = "
            DELETE FROM {$this->table}
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function show(int $id) : object
    {
        $sql = "
            SELECT *
            FROM {$this->table}
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function showAll() : array
    {
        $sql = "
            SELECT *
            FROM {$this->table}
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    
    public function count($fieldName, $needle) : int
    {
        $sql = "SELECT COUNT(id) AS count FROM {$this->table} WHERE ? = ?"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$fieldName, $needle]);
        return $stmt->fetchColumn();
    }

    public function nextID() : int 
    {
        $sql = "SELECT Max({$this->table}.id) AS MaxID FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn() + 1;
    }

}