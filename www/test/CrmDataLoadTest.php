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
     * @var DBInterface|__anonymous@434
     */
    private $dbHandler;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dbHandler = new class implements DBInterface{
            /**
             * @return object
             */
            public function getConnection(): object
            {
                return new class {
                    public function insertInto(string $table, array $array) {
                        return $this;
                    }
                    public function execute() {
                        return true;
                    }
                };
            }
        };
    }


    public function testSaveDataSet()
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
        $this->model = new CrmDataLoad($this->dbHandler, $data);

        $results = $this->model->saveDataSet();
        $this->assertIsArray($results);
        $this->assertContainsEquals(1, $results);
        $this->assertEquals([true, true], $results);
        //$this->assertTrue(true);
    }
}



