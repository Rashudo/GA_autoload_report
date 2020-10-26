<?php


namespace Crm_Getter\Classes;


use Crm_Getter\Interfaces\DbInterface;
use Crm_Getter\src\Crm;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * Class CrmDataLoad
 * @package Crm_Getter\Classes
 */
class CrmDataLoad
{
    /**
     * @var DBInterface
     */
    private DBInterface $db;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CrmDataLoad constructor.
     * @param DBInterface $dbHandler
     * @param LoggerInterface $logger
     */
    public function __construct(DbInterface $dbHandler, LoggerInterface $logger)
    {
        $this->db = $dbHandler;
        $this->logger = $logger;
    }

    public function saveDataSet(array $data): array
    {
        $results = [];
        try {
            foreach ($data as $line) {
                $obj = new Crm;
                $obj->setOrderId($line['order_id']);
                $obj->setChannel($line['channel']);
                $obj->setAdv($line['adv']);
                $this->db->saveData($obj);
                $results[] = $obj->getOrderId() > 0;
            }
        } catch (Exception $e) {
            $this->logger->error('Class = ' . __CLASS__ . '. Line = ' . __LINE__ . ' Error = ' . $e);
            die($e);
        }
        return $results;
    }
}