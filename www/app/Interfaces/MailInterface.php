<?php

namespace Crm_Getter\Interfaces;

/**
 * Interface iMailer
 * @package Crm_Getter\Interfaces
 */
interface MailInterface
{

    /**
     * @return void
     */
    public function connect(): void;

    /**
     * @return mixed
     */
    public function closeConnection();

    /**
     * @param int $msg_index
     * @return \stdClass
     */
    public function getMail(int $msg_index): \stdClass;
}
