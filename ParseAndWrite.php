<?php

class ParseAndWrite
{
    public function xlsToDB()
    {
        $db = DataBase::getDB();
      
        if (!file_exists('pricelist.xls')) {
            exit('File is not found');
        }

        $xls = PHPExcel_IOFactory::load('pricelist.xls');
        $xls->setActiveSheetIndex(0);

        foreach ($xls->getWorksheetIterator() as $worksheet) // цикл по данным файла
        {
            $highestRow = $worksheet->getHighestRow(); //  количество строк

            for ($row = 1; $row <= $highestRow; $row++) // обходим все строки
            {

                if ($row == 1) {
                    $arr = array();
                    array_push($arr, "№", $worksheet->getCellByColumnAndRow(0, $row),
                    $worksheet->getCellByColumnAndRow(1, $row), $worksheet->getCellByColumnAndRow(2, $row),
                    $worksheet->getCellByColumnAndRow(3, $row), $worksheet->getCellByColumnAndRow(4, $row),
                    $worksheet->getCellByColumnAndRow(5, $row));
                    continue;
                }

                $cell1 = $worksheet->getCellByColumnAndRow(0, $row); //Товар
                $cell2 = $worksheet->getCellByColumnAndRow(1, $row); //Цена
                $cell3 = $worksheet->getCellByColumnAndRow(2, $row); //Опт.Цена
                $cell4 = $worksheet->getCellByColumnAndRow(3, $row); //НаличинаСклад1
                $cell5 = $worksheet->getCellByColumnAndRow(4, $row); //НаличиеСклад2
                $cell6 = $worksheet->getCellByColumnAndRow(5, $row); //Страна

                $db->xlsToMySqlSData($cell1, $cell2, $cell3, $cell4, $cell5, $cell6);
            }
        }
        return $arr;
    }
}
