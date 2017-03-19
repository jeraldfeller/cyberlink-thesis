<?php
require '../../Model/Init.php';
require '../../Model/Customer.php';

$action = $_GET['action'];
$customerClass = new Customer();

switch($action){
    case 'register':
        $email = $_POST['email'];
        $password = $_POST['password'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $dateOfBirth = date('Y-m-d', strtotime($_POST['dateOfBirth']));
        $address = addslashes($_POST['address']);
        $city = addslashes($_POST['city']);
        $homeNumber = $_POST['homeNumber'];
        $mobileNumber = $_POST['mobileNumber'];
        $dateRegistered = date('Y-m-d');
        echo $customerClass->registerCustomer($email, $password, $firstName, $lastName, $dateOfBirth, $address, $city, $homeNumber, $mobileNumber, $dateRegistered);
        break;
    case 'login':
        $data = json_decode($_POST['param'], true);
        echo $customerClass->customerLogin($data['email'], $data['password']);
        break;
}

