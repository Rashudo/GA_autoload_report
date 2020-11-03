<?php


namespace test;


use Crm_Getter\Classes\CrmParse;

class CrmParseTest extends AbstractClass
{

    /**
     * @var CrmParse
     */
    private $model;


    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testSaveDataSet(): void
    {

        $data = <<<EOT
            # ----------------------------------------
            # Профиль (фильтр)
            # Электронная торговля
            # 20200101-20200101
            # ----------------------------------------
            
            Идентификатор транзакции,Кампания,Источник или канал,Доход
            1,(not set),yandex / organic,"100,00 ₽"
            2,brand_search_|1111,yandex / cpc,"42,42 ₽"
            3,brand_search|test,google / cpc,"20 ₽"
            4,,
        EOT;

        $this->model = new CrmParse;
        $this->model->setData($data);
        $results = $this->model->getDataSet();

        $this->assertIsArray($results);
        $this->assertCount(4, $results);
        foreach ($results as $res_line) {
            $this->assertArrayHasKey('order_id', $res_line);
            $this->assertArrayHasKey('adv', $res_line);
            $this->assertArrayHasKey('channel', $res_line);
            $this->assertGreaterThan(0, $res_line['order_id']);
        }
    }
}