<?php
require '../../Model/Init.php';
require '../../Model/Products.php';
require '../../Model/Orders.php';


$action = $_GET['action'];
$productsClass = new Products();

switch($action){
    case 'add':

        $catId = $_POST['addCategory'];
        $supId = $_POST['addSupplier'];
        $stockId = $_POST['addStockId'];
        $productName = $_POST['addProduct'];
        $description = addslashes($_POST['addDescription']);
        $originPrice = str_replace(',','', '' .$_POST['addOriginalPrice'] . '');
        $sellingPrice = str_replace(',','', '' .$_POST['addSellingPrice'] . '');
        $quantity = $_POST['addQuantity'];
        $profit = $sellingPrice - $originPrice;
        $brandName = $_POST['addBrand'];
        $dateArrival =  date('Y-m-d', strtotime($_POST['addDateArrival']));
        $isFeatured = (isset($_POST['addFeatured']) ? $_POST['addFeatured'] : 0);

        //image handler

        $image_name =  addslashes($_FILES["addFile"]["name"]);
        $target_dir = ROOT."/images/products/";
        $target_file = $target_dir . basename($_FILES["addFile"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(isset($_FILES["addFile"]['tmp_name'])){
            if($_FILES["addFile"]['tmp_name'] != '' || $_FILES["addFile"]['tmp_name'] != null){
               // $item_photo = addslashes(file_get_contents($_FILES["addFile"]['tmp_name']));
                move_uploaded_file($_FILES["addFile"]["tmp_name"], $target_file);

            }else{
                $image_name = null;
                //$item_photo = null;
            }
        }else{
           // $item_photo = null;
            $image_name = null;
        }




        echo $productsClass->addProduct(
                $catId,
                $supId,
                $stockId,
                $productName,
                $description,
                $originPrice,
                $sellingPrice,
                $quantity,
                $profit,
                $brandName,
                $dateArrival,
                $image_name,
                $isFeatured
        );

        break;


    case 'edit':

        $productId = $_POST['editProductId'];
        $catId = $_POST['editCategory'];
        $supId = $_POST['editSupplier'];
        $stockId = $_POST['editStockId'];
        $productName = $_POST['editProduct'];
        $description = addslashes($_POST['editDescription']);
        $originPrice = str_replace(',','', '' .$_POST['editOriginalPrice'] . '');
        $sellingPrice = str_replace(',','', '' .$_POST['editSellingPrice'] . '');
        $quantity = $_POST['editQuantity'];
        $profit = $sellingPrice - $originPrice;
        $brandName = $_POST['editBrand'];
        $dateArrival =  date('Y-m-d', strtotime($_POST['editDateArrival']));
        $image = $_POST['editImage'];
        $isFeatured = (isset($_POST['editFeatured']) ? $_POST['editFeatured'] : 0);

        //image handler

        $image_name =  addslashes($_FILES["editFile"]["name"]);
        $target_dir = ROOT."/images/products/";
        $target_file = $target_dir . basename($_FILES["editFile"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(isset($_FILES["editFile"]['tmp_name'])){
            if($_FILES["editFile"]['tmp_name'] != '' || $_FILES["editFile"]['tmp_name'] != null){
                // $item_photo = editslashes(file_get_contents($_FILES["editFile"]['tmp_name']));
                move_uploaded_file($_FILES["editFile"]["tmp_name"], $target_file);

            }else{
                $image_name = $image;
                //$item_photo = null;
            }
        }else{
            // $item_photo = null;
            $image_name = $image;
        }




        echo $productsClass->editProduct(
            $productId,
            $catId,
            $supId,
            $stockId,
            $productName,
            $description,
            $originPrice,
            $sellingPrice,
            $quantity,
            $profit,
            $brandName,
            $dateArrival,
            $image_name,
            $isFeatured
        );

        break;

    case 'borrow':
        $data = json_decode($_POST['param'], true);
        echo $productsClass->borrowItem($data['productId'], $data['quantity'], addslashes($data['notes']));
        break;

    case 'delete':
        $productId = $_POST['param'];
        $productsClass->deleteProduct($productId);
        break;
    case 'getProducts':
        echo $productsClass->getProducts();
        break;

    case 'checkOut':
        $data = json_decode($_POST['param'], true);
        $ordersClass = new Orders();
        $ordersClass->insertOrders($data);

        echo true;
        break;
}