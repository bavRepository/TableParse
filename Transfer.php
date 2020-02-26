<?php

require_once ('DataBase.php');


$db = DataBase::getDB();



    $selKindPrice = $_POST['selKindPrice'];
    $selMoreLess = $_POST['selMoreLess'];
    $priceRange1 = $_POST['priceRange1'];
    $priceRange2 = $_POST['priceRange2'];
    $countItems = $_POST['countItems'];

    $priceRange1 = str_replace(" ","",$priceRange1);
    $priceRange2 = str_replace(" ","",$priceRange2);
    $countItems = str_replace(" ","",$countItems);

    
      
        function ifRightData($val) {
           
            $json_arr = array();
            while( $row = mysqli_fetch_array($val)) {
                $json_arr[] = $row;
            }
            
            return $json_arr;
        }

        $add = $db->myFilter($selKindPrice, $priceRange1, $priceRange2, $selMoreLess, $countItems);


        if ($priceRange1 == "" || $priceRange2 == "" ||  $countItems == "" ) {
            echo "empty";
         
         }elseif (filter_var($priceRange1, FILTER_VALIDATE_INT) === false || filter_var($priceRange2, FILTER_VALIDATE_INT) === false || filter_var($countItems, FILTER_VALIDATE_INT) === false) {
            echo "IsNotNumber";
         }else {
          
            $priceRange1 = intval($priceRange1);
            $priceRange2 = intval($priceRange2);
            $countItems = intval($countItems);
            $arr = ifRightData($add);
            
         mysqli_free_result($add);
            echo json_encode($arr);
         }
    ?>