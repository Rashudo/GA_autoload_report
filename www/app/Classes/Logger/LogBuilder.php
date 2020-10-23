<?php


namespace Crm_Getter\Classes\Logger;


use Crm_Getter\Classes\Logger\Loggers\ConsoleLogger;
use Crm_Getter\Classes\Logger\Loggers\FileLogger;
use Crm_Getter\Interfaces\LogBuilderInterface;
use Psr\Log\LoggerInterface;

/**
 * Class LogBuilder
 * @package Crm_Getter\Classes\Logger
 */
final class LogBuilder implements LogBuilderInterface
{

    /**
     * @var LoggerInterface
     */
    private $logModel;

    /**
     * @return LoggerInterface
     */
    public function getObject(): LoggerInterface
    {
        return $this->logModel;
    }


    /**
     * @return LogBuilderInterface
     */
    public function setConsoleModel(): LogBuilderInterface
    {
        $this->logModel = new ConsoleLogger();

        return $this;
    }


    /**
     * @return LogBuilderInterface
     */
    public function setFileModel(): LogBuilderInterface
    {
        $this->logModel = new FileLogger();

        return $this;
    }


}