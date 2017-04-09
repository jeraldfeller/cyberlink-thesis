<?php
require ROOT.'/Model/Category.php';
require ROOT.'/Model/Supplier.php';
require ROOT.'/Model/Products.php';
require ROOT.'/Model/Orders.php';

class FormElements {

    public function getDisplaySelectCategories(){
        $categories = new Category();
        $output = '';
        foreach($categories->getCategory() as $row){
            $output .= '<option value="' . $row['cat_id'] . '">' . $row['title'] . '</option>';
        }

        return $output;

    }

    public function getDisplayListCategories(){
        $categories = new Category();
        $output = '';
        foreach($categories->getCategory() as $row){
            $output .= '<li><a href="products?cat_id=' . $row['cat_id'].'">' . strtoupper($row['title']) . '</a></li>';
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


    public function getDisplayFeaturedProducts(){
        $products = new Products();
        $output = '';
        foreach($products->getProductFeatured() as $row){
            $output .= '<li class="span3">
                            <div class="thumbnail">
                                <a  href="product_details?cat_id=' . $row['cat_id'] . '&product_id=' . $row['product_id'] . '"><img src="http://admin.cyberlink.com/images/products/' . $row['image_name'] . '" width="160" height="160" alt=""/></a>
                                <div class="caption">
                                    <h5>' . $row['product_name'] . '</h5>
                                    <p>
                                        ' . substr($row['description'], 0, 50) . '...
                                        <a  href="product_details?cat_id=' . $row['cat_id'] . '&product_id=' . $row['product_id'] . '">[read more]</a>
                                    </p>

                                    <h4 style="text-align:center"><a class="btn" href="product_details?cat_id=' . $row['cat_id'] . '&product_id=' . $row['product_id'] . '"> <i class="icon-zoom-in"></i></a> <button class="btn" href="#" data-product-id="' . $row['product_id'] . '" data-selling-price="' . $row['selling_price'] . '" data-base-price="' . $row['original_price'] . '" onClick="addToCartSingle(this)">Add to <i class="icon-shopping-cart"></i></button> <a class="btn btn-primary" href="#">Php' . number_format($row['selling_price'], 2) . '</a></h4>
                                </div>
                            </div>
                        </li>';
        }


        return $output;
    }


    public function getDisplayLatestProducts(){
        $products = new Products();
        $output = '';
        foreach($products->getProductLatest() as $row){
            $output .= '<li class="span3">
                            <div class="thumbnail">
                                <a  href="product_details?cat_id=' . $row['cat_id'] . '&product_id=' . $row['product_id'] . '"><img src="http://admin.cyberlink.com/images/products/' . $row['image_name'] . '" width="160" height="160" alt=""/></a>
                                <div class="caption">
                                    <h5>' . $row['product_name'] . '</h5>
                                    <p>
                                        ' . substr($row['description'], 0, 50) . '...
                                        <a  href="product_details?cat_id=' . $row['cat_id'] . '&product_id=' . $row['product_id'] . '">[read more]</a>
                                    </p>

                                    <h4 style="text-align:center"><a class="btn" href="product_details?cat_id=' . $row['cat_id'] . '&product_id=' . $row['product_id'] . '"> <i class="icon-zoom-in"></i></a> <button class="btn" href="#" data-product-id="' . $row['product_id'] . '" data-selling-price="' . $row['selling_price'] . '" data-base-price="' . $row['original_price'] . '" onClick="addToCartSingle(this)">Add to <i class="icon-shopping-cart"></i></button> <a class="btn btn-primary" href="#">Php' . number_format($row['selling_price'], 2) . '</a></h4>
                                </div>
                            </div>
                        </li>';
        }


        return $output;
    }


    public function getDisplayProducts($catId, $sort, $direction){
        $products = new Products();
        $output = '';
        foreach($products->getProductByCategory($catId, $sort, $direction) as $row){
            $output .= '<li class="span3">
                            <div class="thumbnail">
                                <a  href="product_details?cat_id=' . $catId . '&product_id=' . $row['product_id'] . '"><img src="http://admin.cyberlink.com/images/products/' . $row['image_name'] . '" width="160" height="160" alt=""/></a>
                                <div class="caption">
                                    <h5>' . $row['product_name'] . '</h5>
                                    <p>
                                        ' . substr($row['description'], 0, 50) . '...
                                        <a  href="product_details?cat_id=' . $catId . '&product_id=' . $row['product_id'] . '">[read more]</a>
                                    </p>

                                    <h4 style="text-align:center"><a class="btn" href="product_details?cat_id=' . $catId . '&product_id=' . $row['product_id'] . '"> <i class="icon-zoom-in"></i></a> <button class="btn" href="#" data-product-id="' . $row['product_id'] . '" data-selling-price="' . $row['selling_price'] . '" data-base-price="' . $row['original_price'] . '" onClick="addToCartSingle(this)">Add to <i class="icon-shopping-cart"></i></button> <a class="btn btn-primary" href="#">Php' . number_format($row['selling_price'], 2) . '</a></h4>
                                </div>
                            </div>
                        </li>';
        }


        return $output;
    }


    public function getDisplayCartTable(){
        $products = new Products();
        $output = '';
        if(isset($_SESSION['cart'])){
            $count = 0;
            foreach($_SESSION['cart'] as $row){
                $product = $products->getProductById($row['productId']);
                $output .= '<tr id="index_' . $count . '" data-index="' . $count . '" data-product-id="' . $row['productId'] . '" data-original-price="' . $product['original_price'] . '" data-selling-price="' . $product['selling_price'] . '" data-profit="' . $product['profit'] . '" class="rowItems">
                            <td style="display: none;"><input type=text" value="' . $row['baseTotalPrice'] . '" id="total_base_input_' . $count . '"</td>
                            <td style="display: none;"><input type=text" value="' . $row['totalPrice'] . '" id="total_input_' . $count . '"</td>
                            <td> <img width="60" src="http://admin.cyberlink.com/images/products/' . $product['image_name'] . '" alt=""/></td>
                            <td>' . $product['description'] . '</td>
                            <td>
                                <div class="input-append">
                                    <input onkeypress="return isNumberKey(event)" onKeyUp="updateQuantity(this)" data-index="' . $count . '" data-product-id="' . $row['productId'] . '" data-selling-price="' . $product['selling_price'] . '" value="' . $row['quantity'] . '" class="span1" style="max-width:34px" placeholder="1" id="qty_' . $count . '" size="16" type="text">
                                    <button class="btn" type="button" data-action="minus" data-index="' . $count . '" data-product-id="' . $row['productId'] . '" data-selling-price="' . $product['selling_price'] . '" data-base-price="' . $product['original_price'] . '" onClick="updateQuantity(this)">
                                        <i class="icon-minus"></i>
                                    </button>
                                    <button class="btn" type="button" data-action="plus" data-index="' . $count . '" data-product-id="' . $row['productId'] . '" data-selling-price="' . $product['selling_price'] . '" data-base-price="' . $product['original_price'] . '" onClick="updateQuantity(this)">
                                        <i class="icon-plus"></i>
                                    </button>
                                    <button class="btn btn-danger" type="button" data-action="remove" data-index="' . $count . '" data-product-id="' . $row['productId'] . '" data-base-price="' . $product['original_price'] . '" onClick="updateQuantity(this)">
                                        <i class="icon-remove icon-white"></i>
                                    </button>
                                </div>
                            </td>
                            <td>Php' . number_format($product['selling_price'], 2) . '</td>
                            <td>Php<span id="total_price_' . $count . '">' . number_format($row['totalPrice'], 2) . '</span></td>
                        </tr>';
                $count++;
            }


            return $output;
        }
    }


    public function getDisplayOrdersTable($customerId){
        $orders = new Orders();
        $output = '';
            foreach($orders->getOrdersByCustomerId($customerId) as $row){
                $output .= '<tr>
                            <td>' . $row['transaction_id'] . '</td>
                            <td>' . $row['mode_of_payment'] . '</td>
                            <td>' . $row['delivery_address'] . '</td>
                            <td>' . date('m/d/Y', strtotime($row['date_of_delivery'])) . '</td>
                            <td>' . number_format($row['total_price']) . '</td>
                            <td>' . $row['status'] . '</td>
                            <td><a href="invoice?id=' . $row['transaction_id'] . '" class="btn btn-primary btn-mini">View Details</a></td>
                        </tr>';
            }


            return $output;

    }


    public function getDisplayOrdersItemsTable($items){
        $products = new Products();
        $output = '';
            foreach($items as $row){
                $product = $products->getProductById($row['product_id']);
                $output .= '<tr>
                            <td> <img width="60" src="http://admin.cyberlink.com/images/products/' . $product['image_name'] . '" alt=""/></td>
                            <td>' . $product['description'] . '</td>
                            <td>' . $row['quantity'] . '</td>
                            <td>Php' . number_format($row['selling_price'], 2) . '</td>
                            <td>Php' . number_format($row['total_price'], 2) . '</span></td>
                        </tr>';
            }


            return $output;

    }



}