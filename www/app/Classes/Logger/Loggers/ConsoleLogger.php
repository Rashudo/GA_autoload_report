<?php


namespace Crm_Getter\Classes\Logger\Loggers;

/**
 * Class ConsoleLogger
 * @package Crm_Getter\Classes\Logger\Loggers
 */
class ConsoleLogger extends AbstractLogger
{

    public function notice($message, array $context = array())
    {
        $this->commonError(__METHOD__, $message, $context);
    }


    public function error($message, array $context = array())
    {
        $this->commonError(__METHOD__, $message, $context);
    }

    private function commonError(string $type, $message, array $context = array())
    {
        error_log('==============');
        error_log($type . '. ' . $message);
        if (count($context) > 0) {
            error_log('Context. ' . json_encode($context));
        }
        error_log('==============');
    }
}