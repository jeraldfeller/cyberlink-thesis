<?php
require '../../Model/Init.php';
require '../../View/FormElements.php';

$action = $_GET['action'];
$view = new FormElements();
switch($action){
    case 'get':
        $data = json_decode($_POST['param'], true);
        if($data['direction'] == 'byPrice'){
            $sort = 'selling_price';
            $direction = 'asc';
        }else{
            $sort = 'product_name';
            $direction = $data['direction'];
        }
        echo $view->getDisplayProducts($data['catId'], $sort, $direction);
        break;
}

