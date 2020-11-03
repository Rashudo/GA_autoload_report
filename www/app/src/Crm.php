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
     *
     * @Column (type="integer")
     *
     * @var int
     */
    private $order_id = 0;

    /**
     * @Column (nullable=true)
     *
     * @var string
     */
    private ?string $channel = null;

    /**
     * @Column (nullable=true)
     *
     * @var string
     */
    private ?string $adv = null;

    public function getOrderId(): int
    {
        return intval($this->order_id);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function setOrderId(int $id): void
    {
        $this->order_id = $id;
    }

    /**
     * @param string $channel
     *
     * @return void
     */
    public function setChannel(string $channel): void
    {
        $this->channel = trim($channel);
    }

    /**
     * @param string $channel
     *
     * @return void
     */
    public function setAdv(string $adv): void
    {
        $this->adv = trim($adv);
    }
}
