<?php
require '../../Model/Init.php';
require '../../Model/Products.php';
require '../../Model/Orders.php';
require '../../Model/Customer.php';



$action = $_GET['action'];
$orderClass= new Orders();

switch($action){
    case 'update':
        $data = json_decode($_POST['param'], true);
        echo $orderClass->updateOrder($data);
        break;
    case 'getOrders':
        echo $orderClass->getOrders();
        break;
}

