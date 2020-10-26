<?php


namespace Crm_Getter\Interfaces;


interface DbInterface
{
    public function saveData(object $object): void;
}