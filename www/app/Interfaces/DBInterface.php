<?php


namespace Crm_Getter\Interfaces;


use Envms\FluentPDO\Query;

interface DBInterface
{

    /**
     * @return Query
     * @throws \Exception
     */
    public function getConnection(): object;
}