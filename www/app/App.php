<?php

namespace Crm_Getter;

use Crm_Getter\Classes\CrmDataLoad;
use Crm_Getter\Classes\CrmParse;
use Crm_Getter\Classes\DbConnect\DoctrineHandler;
use Crm_Getter\Classes\Logger\LogManager;
use Crm_Getter\Classes\Mail;
use Exception;
use Psr\Log\LoggerInterface;
use stdClass;

/**
 * Class App
 * @package Crm_Getter
 */
class App
{
    /**
     * Run application. Enter point
     *
     * @return void
     */
    public function run(): void
    {
        $mailer = new Mail();
        if ($mailer->status) {
            try {
                $parser = new CrmParse();
                $dataLoader = new CrmDataLoad(new DoctrineHandler());
                $complete = [];
                $results = [];

                foreach ($mailer->getIterator() as $elem) {
                    if (
                        isset($elem->header->fromaddress)
                        && $elem->header->fromaddress === getenv('FROM_ADDRESS')
                        && count($elem->attachments) > 0
                    ) {
                        if (isset($elem->attachments[0])) {
                            $parser->setData($elem->attachments[0]);
                            $data_set = $parser->getDataSet();
                            if (count($data_set) > 0) {
                                $complete = array_merge($complete, $data_set);
                            }
                        }
                    }
                    //$mailer->setForDelete($elem->index);
                }
                if (count($complete) > 0) {
                    $results = $dataLoader->saveDataSet($complete);
                }
                if (!(!$results || in_array(0, $results))) {
                    echo 'Сохранено';
                    //$mailer->deleteMessages();
                } else {
                    echo 'Не сохранено';
                }
            } catch (Exception $e) {
                die('Error => ' . $e);
            }
        } else {
            die('No connection to mail server');
        }
    }
}
