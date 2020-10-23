<?php


namespace Crm_Getter\Classes\DbConnect;


use Crm_Getter\Interfaces\DBInterface;
use Crm_Getter\Traits\SingletonTrait;
use Envms\FluentPDO\Query;
use PDO;
use PDOException;
use Psr\Log\LoggerInterface;

/**
 * Class FluentPDO
 * use singleton pattern
 * @package Crm_Getter\Classes\DbConnect
 */
class FluentPDO implements DBInterface
{
    use SingletonTrait;

    /**
     * @var Query
     */
    protected ?Query $db;

    public function run(LoggerInterface $logger)
    {
        try {
            $pdo = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";port=" . DB_PORT . ";charset=UTF8;", DB_LOGIN, DB_PASS);
        } catch (PDOException $e) {
            $logger->error('No db connection');
            die('No db connection');
        }
        $this->db = new Query($pdo);
    }

    /**
     * @return Query
     * @throws \Exception
     */
    public function getConnection(): object
    {
        if (!$this->db) {
            throw new \Exception('No db handler');
        }
        return $this->db;
    }


}