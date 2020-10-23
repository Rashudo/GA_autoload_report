<?php


namespace Crm_Getter\Interfaces;


use Envms\FluentPDO\Query;

/**
 * Interface DBInterface
 * @package Crm_Getter\Interfaces
 */
interface DBInterface
{

    /**
     * @return Query
     * @throws \Exception
     */
    public function getConnection(): object;
}