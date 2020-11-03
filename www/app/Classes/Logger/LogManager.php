<?php

namespace Crm_Getter\Classes\Logger;

use Crm_Getter\Interfaces\LoggerManagerInterface;
use Crm_Getter\Traits\SingletonTrait;
use Psr\Log\LoggerInterface;

/**
 * Class LogManager
 * pattern director
 * @package Crm_Getter\Classes\Logger
 */
class LogManager implements LoggerManagerInterface
{
    /**
     * @return LoggerInterface
     */
    public static function getLogger(): LoggerInterface
    {
        return (LogBuilder::getInstance())
            ->setConsoleModel()
            ->getObject();
    }
}
