<?php

namespace Crm_Getter\Classes;

use ArrayIterator;
use Crm_Getter\Interfaces\iMailer;
use IteratorAggregate;
use stdClass;

class Mail implements iMailer, IteratorAggregate
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
     * Mail constructor.
     */
    public function __construct()
    {
        $this->connect();
        if (is_resource($this->conn)) {
            $this->msg_cnt = imap_num_msg($this->conn);
            if ($this->msg_cnt > 0) {
                $this->setInbox();
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
        $this->conn = imap_open('{' . MAIL_SERVER . '/notls}Inbox', MAIL_USER, MAIL_PASS);
    }

    /**
     *
     */
    private function setInbox()
    {
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
                            $attachment = imap_fetchbody($this->conn, $m, $i + 1);
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
                $this->inbox[] = $mail;
            }
        }
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->inbox);
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    public function closeConnection()
    {
        $this->inbox = array();
        $this->msg_cnt = 0;

        imap_close($this->conn);
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
     * @return array
     */
        public function getMail(int $msg_index): array
    {
        $return = [];
        if (count($this->inbox) >= $msg_index) {
            $return = $this->inbox[$msg_index];
        }
        return $return;
    }

    /**
     * @param int $msg_index
     * @return bool
     */
    public function setForDelete(int $msg_index): bool
    {
        return imap_delete($this->conn, $msg_index);
    }

    /**
     * @return bool
     */
    public function deleteMessages(): bool
    {
        $result = imap_expunge($this->conn);
        $this->setInbox();
        return $result;
    }

}