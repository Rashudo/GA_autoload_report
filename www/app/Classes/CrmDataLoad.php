<?php


namespace Crm_Getter\Classes;


use Crm_Getter\Interfaces\DBInterface;
use Envms\FluentPDO\Exception;

class CrmDataLoad
{
    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var DBInterface
     */
    private DBInterface $db;

    /**
     * CrmDataLoad constructor.
     * @param DBInterface $dbHandler
     * @param array $data
     */
    public function __construct(DBInterface $dbHandler, array $data)
    {
        $this->db = $dbHandler;
        $this->data = $data;
    }

    public function saveDataSet(): array
    {
        $results = [];
        try {
            foreach ($this->data as $line) {
                $results[] = $query = $this->db->getConnection()
                    ->insertInto('crm_ga',
                        [
                            'order_id' => $line['order_id'],
                            'channel' => $line['channel'],
                            'adv' => $line['adv']
                        ]
                    )
                    ->execute();
            }
        } catch (\Exception $e) {
            die($e);
        }
        return $results;
    }
}