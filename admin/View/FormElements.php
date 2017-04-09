<?php
require 'Model/Category.php';
require 'Model/Supplier.php';
require 'Model/Products.php';
require 'Model/Orders.php';
require 'Model/Customer.php';
class FormElements {

    public function getDisplaySelectPos(){
        $products = new Products();
        $output = '';
        foreach($products->getPosItems() as $row){
            $output .= '<option value="' . $row['product_id'] . '|' . $row['image_name'] . '|' .  $row['product_name'] . '|' .  $row['original_price'] . '|' .  $row['selling_price'] . '|' . $row['profit'] . '|' . $row['product_qty'] . '">
                        ' . $row['stock_id'] . ' - ' . $row['brand_name'] . ' - ' . $row['product_name'] . ' - ' . $row['title'] . ' - Php' . number_format($row['selling_price'], 2) . '
                        </option>';
        }

        return $output;

    }

    public function getDisplaySelectCategories(){
        $categories = new Category();
        $output = '';
        foreach($categories->getCategory() as $row){
            $output .= '<option value="' . $row['cat_id'] . '">' . $row['title'] . '</option>';
        }

        return $output;

    }


    public function getDisplaySelectSuppliers(){
        $suppliers = new Supplier();
        $output = '';
        foreach($suppliers->getSupplier() as $row){
            $output .= '<option value="' . $row['sup_id'] . '">' . $row['supplier_name'] . '</option>';
        }
        return $output;
    }

    public function getDisplayBrandDataSet(){
        $brands = new Products();
        $output = array();
        foreach($brands->getBrand() as $row){
            $output[] = $row['brand_name'];
        }


        return json_encode($output);
    }


    public function getDisplayOrdersItemsTable($items){
        $products = new Products();
        $output = '';
        foreach($items as $row){
            $product = $products->getProductById($row['product_id']);
            $output .= '<tr>
                            <td> <img width="60" src="http://admin.cyberlink.com/images/products/' . $product[0]['image_name'] . '" alt=""/></td>
                            <td>' . $product[0]['product_name'] . '</td>
                            <td>' . $row['quantity'] . '</td>
                            <td>Php' . number_format($row['selling_price'], 2) . '</td>
                            <td>Php' . number_format($row['total_price'], 2) . '</span></td>
                        </tr>';

        }


        return $output;

    }




}