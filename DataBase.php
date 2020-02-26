<?php

class DataBase
{
  private static $db = null;
  private $mysqli;

  /* Экземпляр дб. Паттерн Singleton */
  public static function getDB()
  {
    if (self::$db == null) self::$db = new DataBase();
    return self::$db;
  }

  /* Коструктор класса. Подключение к базе. */
  private function __construct()
  {
    $this->mysqli = new mysqli("localhost", "root", "", "myDB"); // при создания объекта у нас уже идет коннект в самом конструкторе
    if ($this->mysqli->connect_error) {
      throw new Exception("Connection to the mysql database failed: " . $this->mysqli->connect_error);
    }
    $this->mysqli->query("SET lc_time_names = 'ru_RU'");
    $this->mysqli->query("SET NAMES 'utf8'");
  }

  /* Функция удаления базы */
  public function delDBdata()
  {
    $this->mysqli->query("TRUNCATE TABLE `devices`");
  }

  // Функция вставки данных в БД 
  public function xlsToMySqlSData($cell1, $cell2, $cell3, $cell4, $cell5, $cell6)
  {
    $this->mysqli->query("INSERT INTO `devices`
        (`goods`,`price`,`wholesalePrice`,`availabilityInStorage1`,`availabilityInStorage2`,`country`)
        VALUES ('$cell1','$cell2','$cell3','$cell4','$cell5', '$cell6')");
  }

    /* Функция выборки данных в соответствии с условием фильтра */
  public function myFilter($namePrice, $from, $up, $MoreLess, $countItems)
  {
    if ($namePrice == "Розничная цена")
      $price = "price";
    else $price = "wholesalePrice";
    if ($MoreLess == "Более")
      $rangeItems = ">";
    else $rangeItems = "<";

    $from = $this->mysqli->real_escape_string($from);
    $up = $this->mysqli->real_escape_string($up);
    $countItems = $this->mysqli->real_escape_string($countItems);

    $result = $this->mysqli->query("SELECT * FROM `devices` WHERE $price > $from AND $price < $up AND (`availabilityInStorage1` + `availabilityInStorage2`) $rangeItems $countItems ORDER BY 'goods'");

    return $result;
  }

  public function selectAll() // взять все из таблицы devices
  {
    $res = $this->mysqli->query("SELECT * FROM `devices`");
    return $res;
  }

  public function sumStorage() // сумма количества оставшегося товара на складе 1 и 2 
  {
    $req = $this->mysqli->query("SELECT SUM(`availabilityInStorage1` + `availabilityInStorage2`) AS `total` FROM `devices`");
    $sum = mysqli_fetch_array($req);
    return $sum['total'];
  }

  public function avgPrice() // средняя цена товара
  {
    $req = $this->mysqli->query("SELECT round(AVG(`price`), 2) AS `avgPrice` FROM `devices`");
    $sum = mysqli_fetch_array($req);
    return $sum['avgPrice'];
  }

  public function avgwholesalePrice() // средняя оптовая цена
  {
    $req = $this->mysqli->query("SELECT round(AVG(`wholesalePrice`), 2) AS `avgPrice` FROM `devices`");
    $sum = mysqli_fetch_array($req);
    return $sum['avgPrice'];
  }

  public function getMaxValue() // максимальная цена
  {
    $getMax = $this->mysqli->query("SELECT MAX(`price`) AS `maxCount` FROM `devices`");
    $resGetMax = mysqli_fetch_array($getMax);
    return $resGetMax['maxCount'];
  }

  public function getMinValue() // минимальная оптовая цена
  {
    $getMin = $this->mysqli->query("SELECT MIN(NULLIF(wholesalePrice, 0)) AS `minCount` FROM `devices`");
    $resGetMin = mysqli_fetch_array($getMin);
    return $resGetMin['minCount'];
  }

  // Закрытие сеанса БД при дестракте объекта
  public function __destruct()
  {
    if ($this->mysqli) $this->mysqli->close();
  }
}
