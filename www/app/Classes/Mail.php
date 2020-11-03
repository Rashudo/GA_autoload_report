<?php

namespace Crm_Getter\Classes;

use ArrayIterator;
use Crm_Getter\Classes\Logger\LogManager;
use Crm_Getter\Interfaces\MailInterface;
use Error;
use IteratorAggregate;
use Psr\Log\LoggerInterface;
use stdClass;

/**
 * Class Mail
 * @package Crm_Getter\Classes
 */
class Mail implements MailInterface, IteratorAggregate
{
    /**
     * @var bool
     */
    public bool $status = false;

    /**
     * @var resource | false
     */
    private $conn = false;

    /**
     * @var array
     */
    private array $inbox = [];


    /**
     * @var int
     */
    private int $msg_cnt = 0;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Mail constructor.
     * @param LoggerInterface $logger
     */
    public function __construct()
    {
        $this->logger = $this->logger = LogManager::getLogger();
        try {
            $this->connect();
        } catch (Error $error) {
            $this->logger->notice('no connection to mail server');
        }
        if (is_resource($this->conn)) {
            $this->setCnt(imap_num_msg($this->conn));
            if ($this->msg_cnt > 0) {
                $this->fillInbox();
            }
            $this->status = true;
        }
    }

    /**
     * Connect to server
     *
     * @return void
     */
    public function connect(): void
    {
        $this->conn = imap_open('{' . getenv('MAIL_SERVER') . '/notls}Inbox', getenv('MAIL_USER'), getenv('MAIL_PASS'));
    }

    /**
     * @param int $msg_cnt
     *
     * @return void
     */
    public function setCnt(int $msg_cnt): void
    {
        $this->msg_cnt = $msg_cnt;
    }

    /**
     * @return void
     */
    private function fillInbox(): void
    {
        if ($this->conn) {
            for ($m = 1; $m <= $this->msg_cnt; $m++) {
                $mail = new stdClass();
                $mail->index = $m;

                $mail->header = @imap_headerinfo($this->conn, $m);
                $mail->structure = @imap_fetchstructure($this->conn, $m);
                if (is_object($mail->header) && is_object($mail->structure)) {
                    $mail->attachments = [];
                    if (isset($mail->structure->parts) && count($mail->structure->parts)) {
                        $i = 0;
                        $is_attachment = false;
                        while ($i < count($mail->structure->parts)) {
                            if ($mail->structure->parts[$i]->ifdparameters) {
                                foreach ($mail->structure->parts[$i]->dparameters as $object) {
                                    if (strtolower($object->attribute) == 'filename') {
                                        $is_attachment = true;
                                        break;
                                    }
                                }
                            }
                            if ($mail->structure->parts[$i]->ifparameters) {
                                foreach ($mail->structure->parts[$i]->parameters as $object) {
                                    if (strtolower($object->attribute) == 'name') {
                                        $is_attachment = true;
                                        break;
                                    }
                                }
                            }
                            if ($is_attachment) {
                                $attachment = imap_fetchbody($this->conn, $m, strval($i + 1));
                                if ($mail->structure->parts[$i]->encoding == 3) {
                                    $attachment = base64_decode($attachment);
                                } elseif ($mail->structure->parts[$i]->encoding == 4) {
                                    $attachment = quoted_printable_decode($attachment);
                                }
                                $mail->attachments[] = $attachment;
                            }
                            ++$i;
                        }
                    }
                    $this->setInbox($mail);
                }
            }
        }
    }

    /**
     * @param stdClass $mail
     *
     * @return void
     */
    public function setInbox(stdClass $mail): void
    {
        $this->inbox[$mail->index] = $mail;
    }

    /**
     * Mail destructor.
     */
    public function __destruct()
    {
        $this->closeConnection();
    }

    /**
     *
     */
    public function closeConnection(): void
    {
        $this->inbox = array();
        $this->msg_cnt = 0;
        if ($this->conn) {
            imap_close($this->conn);
        } else {
            $this->logger->error('no connection to mail server');
        }
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->inbox);
    }

    /**
     * @return int
     */
    public function getCnt(): int
    {
        return $this->msg_cnt;
    }

    /**
     * @param int $msg_index
     * @return stdClass
     */
    public function getMail(int $msg_index): stdClass
    {
        $return = new stdClass();
        if (count($this->inbox) >= $msg_index) {
            $return = $this->inbox[$msg_index];
        }
        return $return;
    }
}
