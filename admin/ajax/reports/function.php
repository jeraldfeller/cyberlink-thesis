<?php
require '../../Model/Init.php';
require '../../Model/Products.php';
require '../../Model/Orders.php';
require '../../Model/Customer.php';



$action = $_GET['action'];
$orderClass= new Orders();

switch($action){
    case 'getReports':
        echo $orderClass->getReports();
        break;
}

