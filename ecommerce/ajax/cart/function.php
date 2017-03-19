<?php
require '../../Model/Init.php';
require '../../View/FormElements.php';


$action = $_GET['action'];
$view = new FormElements();

switch($action){
    case 'add':

        $data = json_decode($_POST['param'], true);

            $totalPrice = $data['quantity'] * $data['price'];
            $_SESSION['partial_total'] += $totalPrice;
            $_SESSION['cart'][$data['productId']] = array('productId' => $data['productId'], 'quantity' => $data['quantity'], 'totalPrice' => $totalPrice);

            $partialPrice = '';
            foreach($_SESSION['cart'] as $row){
               $partialPrice += $row['totalPrice'];
            }

            $_SESSION['partial_total'] = $partialPrice;

            echo json_encode(array('count' => count($_SESSION['cart']),
                                   'partialTotal' => $partialPrice)
                );

        break;

    case 'get':
        $data = $_SESSION['cart'];

}

