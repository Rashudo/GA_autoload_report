<?php


namespace Crm_Getter\Interfaces;


use Psr\Log\LoggerInterface;

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

    /**
     * @return LogBuilderInterface
     */
    public function setFileModel(): LogBuilderInterface;
}