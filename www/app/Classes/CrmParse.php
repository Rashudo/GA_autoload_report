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


    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string[][]
     *
     * @psalm-return array<0|positive-int, array{order_id: string, adv: string, channel: string}>
     */
    public function getDataSet(): array
    {
        $result = [];
        $matches = preg_split('/\n/', $this->data);
        if (is_array($matches)) {
            $i = 0;
            foreach ($matches as $match) {
                $explode = explode(',', $match);
                if ($explode && $explode[0] > 0) {
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
