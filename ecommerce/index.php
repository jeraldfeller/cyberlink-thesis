<?php
include 'includes/header.php';
?>

    <div id="carouselBlk">
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <a href="register.html"><img style="width:100%" src="themes/images/carousel/1.png" alt="special offers"/></a>
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <a href="register.html"><img style="width:100%" src="themes/images/carousel/2.png" alt=""/></a>
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <a href="register.html"><img src="themes/images/carousel/3.png" alt=""/></a>
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>

                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <a href="register.html"><img src="themes/images/carousel/4.png" alt=""/></a>
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>

                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <a href="register.html"><img src="themes/images/carousel/5.png" alt=""/></a>
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <a href="register.html"><img src="themes/images/carousel/6.png" alt=""/></a>
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
    </div>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="cart"><img src="themes/images/ico-cart.png" alt="cart"><span id="bodyItemCount"><?php echo $itemCount; ?></span> <small>Items in your cart</small> <span class="badge badge-warning pull-right">Php<span id="bodyTotalPartial"><?php echo $partialTotal; ?></span></span></a></div>
                    <ul id="sideManu" class="nav nav-tabs nav-stacked">

                        <!-- categories -->
                        <?php
                            echo $view->getDisplayListCategories();
                        ?>
                    </ul>
                    <br/>
                </div>
                <!-- Sidebar end=============================================== -->
                <div class="span9">
                    <h4>Featured Products </h4>
                    <ul class="thumbnails">
                        <?php
                        echo $view->getDisplayFeaturedProducts();
                        ?>
                    </ul>
                    <h4>Latest Products </h4>
                    <ul class="thumbnails">
                        <?php
                        echo $view->getDisplayLatestProducts();
                        ?>
                    </ul>

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
    function addToCartSingle(elem){
        $quantity = 1;
        $productId = elem.getAttribute('data-product-id');
        $price = elem.getAttribute('data-selling-price');
        $basePrice = elem.getAttribute('data-base-price');

        $data = {
            productId: $productId,
            price: $price,
            basePrice: $basePrice,
            quantity: $quantity

        }
        addToCart($data);
    }
</script>
<?php
include 'includes/footer.php';
?>