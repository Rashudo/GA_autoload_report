<?php

namespace Crm_Getter\Interfaces;

use Psr\Log\LoggerInterface;

/**
 * Class LoggerManagerInterface
 * @package Crm_Getter\Interfaces
 */
interface LoggerManagerInterface
{

    /**
     * @return LoggerInterface
     */
    public static function getLogger(): LoggerInterface;
}
