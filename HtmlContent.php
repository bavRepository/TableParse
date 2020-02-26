<?php

class HtmlContent {
       
    public function getFirstline() {
        $readXls = new ParseAndWrite();
       $firstLine = $readXls->xlsToDB();
        return $firstLine;
    }

    public function getTable($some) {
        
        $db = DataBase::getDB();
        $result = $db->selectAll();
          $rows = mysqli_num_rows($result); // количество полученных строк
      
        $str = "<tr>";
        for ($i = 0; $i < count($some); $i++) {
            $str.="<th>".$some[$i]."</th>";
        }
        $str.="<th>Примечание</th></tr>";

        
      for ($j = 0 ; $j < $rows ; $j++)
        {
            $row = mysqli_fetch_row($result);
            
            $str.="<tr class=\"del\">";

            // формируем верстку первоначального вида загрузки страницы. Кое-какие действия над данными
            for ($k = 0 ; $k < 8; $k++) {
                if ($k == 2 && ($row[2] == ($maxV = $db->getMaxValue()))) {
                    $str.="<td class=\"del\" style='background:red;'>$row[$k]</td>"; 
                 }else if ($k == 3 && ($row[3] == ($minV = $db->getMinValue()))) {
                    $str.="<td class=\"del\" style='background:green;'>$row[$k]</td>";
                } else if ($k == 7 && ($row[4]+$row[5] <= 20)) {
                    $str.="<td class=\"del\">Осталось мало!! Срочно докупите!!!</td>";
                } else if ($k == 7) {
                    $str.="<td class=\"del\"></td>";
                } else {
                    $str.="<td class=\"del\">$row[$k]</td>";
                }
            }
            $str.="</tr>";
    }
    mysqli_free_result($result);
   return $str;
}
// футер. Там выводим 
public function getBotValue() 
    {         
        $db = DataBase::getDB();
        $bottFill = "Общее число товаров на складах: ".$sumRes = $db->sumStorage()."<span class=\"sumRes\">".$sumRes."</span><br>Средняя стоимость розничной цены товара: ".$sumRes = $db->avgPrice()."<span class=\"sumRes\">".$sumRes."</span><br>Средняя стоимость оптовой цены товара: ".$sumRes = $db->avgwholesalePrice()."<span class=\"sumRes\">".$sumRes."</span><br>";
        
        return $bottFill;
    }

}
