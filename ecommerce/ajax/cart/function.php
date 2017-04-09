<?php
require '../../Model/Init.php';
require '../../Model/Products.php';
require '../../Model/Orders.php';


$action = $_GET['action'];

switch($action){
    case 'add':

        $data = json_decode($_POST['param'], true);
            if(isset($data['remove'])){
                unset( $_SESSION['cart'][$data['productId']]);
            }else{
                $_SESSION['partial_total'] = 0;
                $_SESSION['base_partial_total'] = 0;
                $totalPrice = $data['quantity'] * $data['price'];
                $baseTotalPrice = $data['quantity'] * $data['basePrice'];
                $_SESSION['base_partial_total'] += $baseTotalPrice;
                $_SESSION['partial_total'] += $totalPrice;
                $_SESSION['cart'][$data['productId']] = array('productId' => $data['productId'], 'quantity' => $data['quantity'], 'baseTotalPrice' => $baseTotalPrice, 'totalPrice' => $totalPrice);
            }

            $partialPrice = 0;
            $baseTotalPrice = 0;
            foreach($_SESSION['cart'] as $row){
               $partialPrice += $row['totalPrice'];
               $baseTotalPrice += $row['baseTotalPrice'];
            }

            $_SESSION['partial_total'] = $partialPrice;
            $_SESSION['base_partial_total'] = $baseTotalPrice;
            echo json_encode(array('count' => count($_SESSION['cart']),
                                   'partialTotal' => $partialPrice,
                                   'basePartialTotal' => $baseTotalPrice)
                );

        break;

    case 'get':
        $data = $_SESSION['cart'];
        break;
    case 'checkOut':
        if(isset($_SESSION['is_logged'])){
            $data = json_decode($_POST['param'], true);
            $ordersClass = new Orders();
            $ordersClass->insertOrders($data);
            unset( $_SESSION['cart'] );
            unset( $_SESSION['partial_total'] );
            unset( $_SESSION['base_partial_total'] );
            echo json_encode(
                array('error' => false,
                    'message' => 'Success',
                    'invoice' => $data['info']['invoiceId'])
            );
        }else{
            echo json_encode(
                array('error' => true,
                    'message' => 'Please Register/Login first before proceeding to check out')
            );
        }
        break;

}

