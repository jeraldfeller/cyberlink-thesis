<?php
require '../../Model/Init.php';
require '../../Model/Category.php';


$action = $_GET['action'];
$categoryClass = new Category();

switch($action){
    case 'add':
        $title = $_POST['param'];
        echo $categoryClass->addCategory($title);
        break;

    case 'edit':
        $data = json_decode($_POST['param'], true);
        $categoryClass->editCategory($data['title'], $data['catId']);
        echo true;
        break;

    case 'delete':
        $catId = $_POST['param'];
        $categoryClass->deleteCategory($catId);
        echo true;
        break;

    case 'getCategories':

        echo $categoryClass->getCategories();

        break;
}