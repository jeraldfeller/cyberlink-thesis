<?php
require '../../Model/Init.php';
require '../../Model/Supplier.php';


$action = $_GET['action'];
$categoryClass = new Supplier();

switch($action){
    case 'add':
        $data = json_decode($_POST['param'], true);
        echo $categoryClass->addSupplier($data['name'], $data['address'], $data['contactPerson'], $data['contactNo']);
        break;

    case 'edit':
        $data = json_decode($_POST['param'], true);
        $categoryClass->editSupplier($data['name'], $data['address'], $data['contactPerson'], $data['contactNo'], $data['supId']);
        echo true;
        break;

    case 'delete':
        $supId = $_POST['param'];
        $categoryClass->deleteSupplier($supId);
        echo true;
        break;

    case 'getSuppliers':

        echo $categoryClass->getSuppliers();

        break;
}