<?php


namespace test;

use Crm_Getter\Classes\CrmDataLoad;
use Crm_Getter\Interfaces\DBInterface;

class CrmDataLoadTest extends AbstractClass
{

        /**
         * @var CrmDataLoad
         */
        private $model;

    /**
     * @var object
     */
    private $dbHandler;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dbHandler = new class implements DBInterface{
            public function saveData(object $object): void
            {
                // TODO: Implement saveData() method.
            }
        };
    }


    public function testSaveDataSet(): void
    {

        $data = [
            [
                'order_id' => 1,
                'channel' => 'channel',
                'adv' => 'adv'
            ],
            [
                'order_id' => "test",
                'channel' => 1111,
                'adv' => null
            ]
        ];
        $this->model = new CrmDataLoad($this->dbHandler);

        $results = $this->model->saveDataSet($data);
        $this->assertIsArray($results);
        $this->assertContainsEquals(1, $results);
        $this->assertEquals([true, true], $results);
        //$this->assertTrue(true);
    }
}



