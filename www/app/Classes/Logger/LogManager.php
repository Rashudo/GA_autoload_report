<?php


namespace Crm_Getter\Classes\Logger;

use Crm_Getter\Interfaces\LogBuilderInterface;
use Crm_Getter\Interfaces\LoggerManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class LogManager
 * pattern director
 * @package Crm_Getter\Classes\Logger
 */
class LogManager implements LoggerManagerInterface
{
    /**
     * @var LogBuilderInterface
     */
    private $builder;

    /**
     * LogManager constructor.
     */
    public function __construct()
    {
        $this->builder = new LogBuilder();
    }

    /**
     * @return LoggerInterface
     */
    public function consoleLogger(): LoggerInterface
    {
        return $this->builder
            ->setConsoleModel()
            ->getObject();
    }
}