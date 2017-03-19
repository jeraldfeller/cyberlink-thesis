<?php
include 'includes/header.php';

$catId = $_GET['cat_id'];
$categoryClass = new Category();
$category = $categoryClass->getCategoryById($catId);
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
                <br/>
            </div>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                    <li class="active"><?php echo $category['title']; ?></li>
                </ul>
                <h3> <?php echo $category['title']; ?></h3>
                <hr class="soft"/>
                <hr class="soft"/>
                <form class="form-horizontal span6">
                    <div class="control-group">
                        <label class="control-label alignL">Sort By </label>
                        <select id="sortBy">
                            <option value="asc">Product name A - Z</option>
                            <option value="desc">Product name Z - A</option>
                            <option value="byPrice">Price Lowest first</option>
                        </select>
                    </div>
                </form>
                <br class="clr"/>
                <div class="tab-content">
                        <ul class="thumbnails" id="displayProducts">

                        </ul>
                        <hr class="soft"/>
                </div>
                <br class="clr"/>
            </div>
        </div>
    </div>
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
<script>
    $(document).ready(function(){
        $direction = $('#sortBy').val();
        $catId = <?php echo $catId; ?>;
        $data = {
            catId : $catId,
            direction: $direction
        }
        getProducts($data);

        $('#sortBy').on('change', function(){
            $direction = $('#sortBy').val();
            $catId = <?php echo $catId; ?>;
            $data = {
                catId : $catId,
                direction: $direction
            }
            getProducts($data);
        });
    });


    function addToCartSingle(elem){
        $quantity = 1;
        $productId = elem.getAttribute('data-product-id');
        $price = elem.getAttribute('data-selling-price');


        $data = {
            productId: $productId,
            price: $price,
            quantity: $quantity

        }
        addToCart($data);
    }
</script>
<!-- Ajax Calls -->
<script src="ajax/products/ajax-products.js"></script>
<!-- MainBody End ============================= -->
<?php
include 'includes/footer.php';
?>