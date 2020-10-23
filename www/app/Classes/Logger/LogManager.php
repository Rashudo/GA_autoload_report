<?php


namespace Crm_Getter\Classes\Logger;

use Crm_Getter\Interfaces\LogBuilderInterface;
use Psr\Log\LoggerInterface;

class LogManager
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