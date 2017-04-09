<?php
require '../../Model/Init.php';
require '../../Model/Orders.php';
require '../../Model/Customer.php';

$action = $_GET['action'];
$customerClass = new Customer();

switch($action){
    case 'getCustomers':
        echo $customerClass->getCustomers();
        break;
    case 'getCustomerOrdersById':
        echo $customerClass->getCustomerOrdersById($_GET['customer-id'], $_GET['status']);
        break;
}

