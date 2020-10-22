<?php


namespace Crm_Getter\Classes;


use Crm_Getter\Interfaces\DBInterface;

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
        $query = 'INSERT INTO crm_ga (order_id,channel,adv) VALUES (:order_id,:channel,:adv)';
        foreach ($this->data as $line) {
            $results[] = $this->db->insert($query, [
                ':order_id' => $line['order_id'],
                ':channel' => $line['channel'],
                ':adv' => $line['adv']
            ]);
        }
        return $results;
    }
}