<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 3/7/2017
 * Time: 4:42 PM
 */



require 'Model/Category.php';
require 'Model/Supplier.php';
require 'Model/Products.php';
class FormElements {


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




}