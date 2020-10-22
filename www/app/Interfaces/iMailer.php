<?php

namespace Crm_Getter\Interfaces;

interface iMailer
{

    /**
     * @return void
     */
    public function connect(): void ;

    /**
     * @return mixed
     */
    public function closeConnection();

    /**
     * @return int
     */
    public function getCnt(): int;

    /**
     * @param int $msg_index
     * @return array
     */
    public function getMail(int $msg_index): array;
}