<?php


namespace test;


use Crm_Getter\Classes\Mail;
use phpDocumentor\Reflection\Types\Void_;

class MailTest extends AbstractClass
{

    /**
     * @var Mail
     */
    private $model;


    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }


    public function testGetMail()
    {
        $this->model = new Mail;

        $mail = $this->getStubMail();

        $this->model->setCnt(1);
        $this->model->setInbox($mail);

        $result = $this->model->getMail(1);
        $this->assertIsObject($result);
        $this->assertObjectHasAttribute('index', $result);
        $this->assertEquals(1, $result->index);
        $this->assertObjectHasAttribute('header', $result);
        $this->assertObjectHasAttribute('structure', $result);
        $this->assertObjectHasAttribute('attachments', $result);
    }


    public static function getStubMail()
    {
        $mail = new \stdClass();
        $mail->index = 1;
        $mail->header = 'testMail';
        $mail->structure = new \stdClass();
        $mail->attachments = [];
        return $mail;
    }

}