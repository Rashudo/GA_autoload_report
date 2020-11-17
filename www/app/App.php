<?php

namespace Crm_Getter;

use Crm_Getter\Classes\CrmDataLoad;
use Crm_Getter\Classes\CrmParse;
use Crm_Getter\Classes\DbConnect\DoctrineHandler;
use Crm_Getter\Classes\Logger\LogManager;
use Crm_Getter\Classes\Mail;
use Exception;

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
                $logger = LogManager::getLogger();
                $parser = new CrmParse();
                $dataLoader = new CrmDataLoad(new DoctrineHandler($logger));
                $complete = [];
                $results = [];
                foreach ($mailer->getIterator() as $elem) {
                    if (
                        isset($elem->header->fromaddress)
                        && $elem->header->fromaddress === getenv('FROM_ADDRESS')
                        && count($elem->attachments) > 0
                    ) {
                        foreach ($elem->attachments as $fileName) {
                            $parser->setData($fileName);
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
                $logger->error('Class = ' . __CLASS__
                    . '. Line = ' . __LINE__
                    . ' OptimisticLockException = ' . $e->getMessage());
            } catch (\Error $error) {
                die($error->getMessage());
            }
        } else {
            die('No connection to mail server');
        }
    }
}
