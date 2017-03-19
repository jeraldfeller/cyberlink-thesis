<?php
require '../../Model/Init.php';
require '../../Model/Products.php';
require '../../Model/BorrowedItems.php';


$action = $_GET['action'];
$borrowedItemsClass = new BorrowedItems();

switch($action) {

    case 'return':
        $data = json_decode($_POST['param'], true);
        echo $borrowedItemsClass->returnItem($data['borrowedItemsId'], $data['productId'], $data['quantity'], $data['action']);
        break;
    case 'getBorrowedItems':
        echo $borrowedItemsClass->getBorrowedItems();
        break;


}