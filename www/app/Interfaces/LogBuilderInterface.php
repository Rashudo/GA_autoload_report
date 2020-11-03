<?php

namespace Crm_Getter\Interfaces;

use Psr\Log\LoggerInterface;

/**
 * Interface LogBuilderInterface
 * @package Crm_Getter\Interfaces
 */
interface LogBuilderInterface
{

    /**
     * @return LoggerInterface
     */
    public function getObject(): LoggerInterface;

    /**
     * @return LogBuilderInterface
     */
    public function setConsoleModel(): LogBuilderInterface;
}
