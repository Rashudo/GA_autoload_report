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
    public string $fileName = '';


    public function setData(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return array
     *
     * @psalm-return array<0|positive-int, array{order_id: string, adv: string, channel: string}>
     *
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getDataSet(): array
    {
        $result = [];
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        $reader->setLoadSheetsOnly('Набор данных1');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($this->fileName);
        $dataArr = $spreadsheet->getActiveSheet()->toArray();
        if (count($dataArr) > 0) {
            $i = 0;
            foreach ($dataArr as $match) {
                if (is_array($match) && count($match) > 2 && $match[0] > 0) {
                    $result[$i]['order_id'] = $match[0];
                    $result[$i]['adv'] = $match[1];
                    $result[$i]['channel'] = $match[2];
                    ++$i;
                }
            }
            unlink($this->fileName);
        }
        return $result;
    }
}
