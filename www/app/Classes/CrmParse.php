<?php


namespace Crm_Getter\Classes;

/**
 * Class CrmParse
 * @package Crm_Getter\Classes
 */
class CrmParse
{

    /**
     * @var string
     */
    public string $data = '';


    public function setData(string $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getDataSet()
    {
        $result = [];
        $matches = preg_split('/\n/', $this->data);
        if (is_array($matches)) {
            $i = 0;
            foreach ($matches as $match) {
                $explode = explode(',', $match);
                if (count($explode) > 0 && $explode[0] > 0) {
                    $result[$i]['order_id'] = $explode[0];
                    $result[$i]['adv'] = $explode[1];
                    $result[$i]['channel'] = $explode[2];
                    ++$i;
                }
            }
        }
        return $result;
    }
}