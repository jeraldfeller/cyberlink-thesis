<?php
include 'includes/header.php';
?>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="cart"><img src="themes/images/ico-cart.png" alt="cart"><span id="bodyItemCount"><?php echo $itemCount; ?> </span><small>Items in your cart</small> <span class="badge badge-warning pull-right">Php<span id="bodyCartTotalPartial"><?php echo $partialTotal; ?></span></span></a></div>
                    <ul id="sideManu" class="nav nav-tabs nav-stacked">
                        <?php
                        echo $view->getDisplayListCategories();
                        ?>
                    </ul>

                </div>
                <!-- Sidebar end=============================================== -->
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active"> My Orders</li>
                    </ul>
                    <h3>  My Orders </h3>
                    <hr class="soft"/>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Mode of Payment</th>
                            <th>Delivery Address</th>
                            <th>Date Of Delivery/Pickup</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $view->getDisplayOrdersTable($_SESSION['customer_id']); ?>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div></div>
    </div>
<?php
include 'includes/footer.php';
?>