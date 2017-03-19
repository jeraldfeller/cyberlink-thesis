<?php
include 'includes/header.php';

$catId = $_GET['cat_id'];
$productId = $_GET['product_id'];
$productClass = new Products();
$product = $productClass->getProductById($productId);

?>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="cart"><img src="themes/images/ico-cart.png" alt="cart"><span id="bodyItemCount">0</span> <small>Items in your cart</small> <span class="badge badge-warning pull-right">Php<span id="bodyTotalPartial">0.00</span></span></a></div>
                    <ul id="sideManu" class="nav nav-tabs nav-stacked">
                        <?php
                        echo $view->getDisplayListCategories();
                        ?>
                    </ul>
                </div>
                <!-- Sidebar end=============================================== -->
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="index">Home</a> <span class="divider">/</span></li>
                        <li><a href="products?cat_id=<?php echo $catId; ?>">Products</a> <span class="divider">/</span></li>
                        <li class="active"><?php echo $product['product_name']; ?></li>
                    </ul>
                    <div class="row">
                        <div id="gallery" class="span3">
                            <a href="http://admin.cyberlink.com/images/products/<?php echo $product['image_name']; ?>" title="<?php echo $product['product_name']; ?>">
                                <img src="http://admin.cyberlink.com/images/products/<?php echo $product['image_name']; ?>" style="width:100%" alt="<?php echo $product['product_name']; ?>"/>
                            </a>
                        </div>
                        <div class="span6">
                            <h3><?php echo $product['product_name']; ?>  </h3>
                            <hr class="soft"/>
                            <div class="form-horizontal qtyFrm">
                                <div class="control-group">
                                    <label class="control-label"><span>Php<?php echo bcdiv($product['selling_price'],1 ,2); ?></span></label>
                                    <div class="controls">
                                        <input type="number" id="quantity" max="<?php echo $product['product_qty']; ?>" min="1" value="1" class="span1" placeholder="Qty."/>
                                        <button type="button" class="btn btn-large btn-primary pull-right" id="addToCart"> Add to cart <i class=" icon-shopping-cart"></i></button>
                                    </div>
                                </div>
                            </div>

                            <hr class="soft"/>
                            <h4><?php echo $product['product_qty']; ?> items in stock</h4>
                            <hr class="soft clr"/>
                            <p>
                                <?php echo $product['description']; ?>

                            </p>
                            <hr class="soft"/>
                        </div>
                    </div>
                </div>
            </div> </div>
    </div>


    <!-- MODAL FOR ADD CART-->

    <div class="modal fade" id="modalAddCart" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
                    <h2 class="modal-title" id="myModalLabel">Notification</h2>
                </div>
                <div class="modal-body">
                            <h4>Product Successfully Added To Cart</h4>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Continue Shopping</button>
                    <a href="cart" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>


    <!-- /MODAL END FOR ADD CART-->
    <!-- MainBody End ============================= -->
<script>
    $(document).on('ready', function(){
        $('#addToCart').click(function(){
            $max = <?php echo $product['product_qty']; ?>;
            $quantity = parseInt($('#quantity').val());
            $productId = <?php echo $product['product_id']; ?>;
            $price = <?php echo $product['selling_price']; ?>


            console.log($quantity);
            if($quantity < 1){
                alert('Please input quantity');
                $('#quantity').focus();
            }
            else if($quantity > $max){
                alert('No. of quantity exceeds the No. of stocks');
            }else{
                $data = {
                    productId: $productId,
                    price: $price,
                    quantity: $quantity
                }
                addToCart($data);
            }

        });
    });
</script>
<?php
include 'includes/footer.php';
?>