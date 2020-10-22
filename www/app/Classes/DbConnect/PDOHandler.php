<?php


namespace Crm_Getter\Classes\DbConnect;

use Crm_Getter\Interfaces\DBInterface;
use PDO;
use PDOException;

class PDOHandler implements DBInterface
{

    /**
     * @var PDO
     */
    public $pdo;


    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";port=" . DB_PORT . ";charset=UTF8;", DB_LOGIN, DB_PASS);
        } catch (PDOException $e) {
            die('Нет подключения к БД');
        }

    }

    /**
     * Good insert method. Put insert query to DB. Clean data by using PDO bindParam
     *
     * @param string $query
     * @param array $selectors
     * @return int
     */
    public function insert(string $query, array $selectors = []): int
    {
        $result = 0;
        try {
            $statement = $this->pdo->prepare($query);
            if ($statement) {
                if (count($selectors) > 0) {
                    foreach ($selectors as $key => &$value) {
                        $statement->bindParam($key, $value);
                    }
                }
                $exec = $statement->execute();
                if ($exec) {
                    $result = ($this->pdo->lastInsertId() > 0) ? $this->pdo->lastInsertId() : intval($exec);
                }
                $statement->closeCursor();
            }
        } catch (PDOException $e) {
            //throw $e;
        }
        return $result;
    }
}