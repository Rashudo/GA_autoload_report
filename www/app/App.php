<?php


namespace Crm_Getter;


use Crm_Getter\Classes\CrmDataLoad;
use Crm_Getter\Classes\CrmParse;
use Crm_Getter\Classes\DbConnect\FluentPDO;
use Crm_Getter\Classes\Logger\LogManager;
use Crm_Getter\Classes\Mail;
use Exception;
use Psr\Log\LoggerInterface;
use stdClass;

class App
{
    /**
     * @var Mail
     */
    private Mail $mailer;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = (new LogManager)->consoleLogger();
        $this->envInit();
        $this->mailer = new Mail($this->logger);
    }

    private function envInit()
    {
        $file = file_get_contents('../.env');
        $explode = explode(PHP_EOL, $file);
        if (count($explode) > 0) {
            array_map(function ($line) {
                $data = explode('=', $line);
                if ($data[0] && $data[1]) {
                    $const = trim($data[0]);
                    if (!defined($const)) {
                        define($const, trim($data[1]));
                    }
                }
            }, $explode);
        }
    }

    public function run()
    {
        if ($this->mailer->status) {
            try {
                $parser = new CrmParse;
                $complete = [];
                foreach ($this->mailer->getIterator() as $elem) {
                    /**
                     * @var $elem stdClass
                     * <dl>
                     * <dt>index
                     * <dt>header
                     * <dt>structure
                     * <dt>attachments
                     * </dl>
                     */
                    if (isset($elem->header->fromaddress) && $elem->header->fromaddress == FROM_ADDRESS && count($elem->attachments) > 0) {
                        if (isset($elem->attachments[0])) {
                            $parser->setData($elem->attachments[0]);
                            $data_set = $parser->getDataSet();
                            if (count($data_set) > 0) {
                                $complete = array_merge($complete, $data_set);
                            }
                        }
                    }
                    $this->mailer->setForDelete($elem->index);
                }
                if (count($complete) > 0) {
                    $pdo = FluentPDO::getInstance();
                    $pdo->run($this->logger);
                    $results = (new CrmDataLoad($pdo, $complete))->saveDataSet();
                }
                die($this->mailer->deleteMessages());

            } catch (Exception $e) {
                die('Error => ' . $e);
            }
        } else {
            die('No connection to mail server');
        }
    }
}