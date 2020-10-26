<?php


namespace Crm_Getter\src;


use Doctrine\ORM\Mapping\{
    Column,
    Entity,
    Id,
    Table
};

/**
 * @Entity
 * @Table(name="crm_ga")
 */
class Crm
{

    /**
     * @Id
     * @Column(type="integer")
     */
    private $order_id;

    /**
     * @Column(nullable=true)
     */
    private $channel;

    /**
     * @Column(nullable=true)
     */
    private $adv;

    public function getOrderId()
    {
        return $this->order_id ?? 0;
    }

    /**
     * @param $id
     */
    public function setOrderId($id)
    {
        $this->order_id = intval($id);
    }

    /**
     * @param string $channel
     */
    public function setChannel(string $channel)
    {
        $this->channel = trim($channel);
    }

    /**
     * @param string $channel
     */
    public function setAdv(string $adv)
    {
        $this->adv = trim($adv);
    }
}