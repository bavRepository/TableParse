<?php

require_once ('DataBase.php'); // подключаем класс дб в архитектуре синглтон
require_once ('PHPExcel/IOFactory.php'); // подключаем библиотеку для работы с парсингом xls файлов
require_once ('ParseAndWrite.php'); // подключаем класс для работы с парсингом и записи результата в бд
require_once ('HtmlContent.php'); // подключаем класс подготовки данных для вставки на страницу


$db = DataBase::getDB(); 
$db->delDBdata();

// $fileParse = new ParseAndWrite();
$content = new HtmlContent();

$firstLine = $content->getFirstline(); // берем первую строку xls и заносим данные в базу остальных ячеек
$readyContent = $content->getTable($firstLine); // формируем контент страницы и данные записываем в переменную
$resultBottomCalc = $content->getbotValue(); // берем данные для футера
      
require_once ('Table.php');
