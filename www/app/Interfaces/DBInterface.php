<?php


namespace Crm_Getter\Interfaces;


interface DBInterface
{

    /**
     * @param string $query
     * @param array $selectors
     * @return int
     */
    public function insert(string $query, array $selectors = []): int;
}