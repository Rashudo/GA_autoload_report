<?php

namespace Crm_Getter\Classes\Logger;

use Crm_Getter\Classes\Logger\Loggers\ConsoleLogger;
use Crm_Getter\Classes\Logger\Loggers\FileLogger;
use Crm_Getter\Interfaces\LogBuilderInterface;
use Crm_Getter\Traits\SingletonTrait;
use Psr\Log\LoggerInterface;

/**
 * Class LogBuilder
 * pattern builder
 * @package Crm_Getter\Classes\Logger
 */
final class LogBuilder implements LogBuilderInterface
{
    use SingletonTrait;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logModel;

    /**
     * @return LoggerInterface
     */
    public function getObject(): LoggerInterface
    {
        return $this->logModel;
    }

    /**
     * @return self
     */
    public function setConsoleModel(): LogBuilderInterface
    {
        $this->logModel = new ConsoleLogger();

        return $this;
    }

    /**
     * @return self
     */
    public function setFileModel(): LogBuilderInterface
    {
        $this->logModel = new FileLogger();

        return $this;
    }
}
