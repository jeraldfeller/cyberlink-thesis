<?php
include 'includes/header.php';
?>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="cart"><img src="themes/images/ico-cart.png" alt="cart"><?php echo $itemCount; ?> <small>Items in your cart</small> <span class="badge badge-warning pull-right">Php<?php echo $partialTotal; ?></span></a></div>
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
                        <li class="active"> SHOPPING CART</li>
                    </ul>
                    <h3>  SHOPPING CART [ <small><?php echo $itemCount; ?> Item(s) </small>]<a href="products" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
                    <hr class="soft"/>
                    <table class="table table-bordered">
                        <?php if(!isset($_SESSION['is_logged'])) { ?>
                        <tr><th> I AM ALREADY REGISTERED  </th></tr>
                        <tr>
                            <td>
                                <form class="form-horizontal">
                                    <div class="control-group">
                                        <label class="control-label" for="inputUsername">Username</label>
                                        <div class="controls">
                                            <input type="text" id="inputUsername" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputPassword1">Password</label>
                                        <div class="controls">
                                            <input type="password" id="inputPassword1" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn">Sign in</button> OR <a href="register.html" class="btn">Register Now!</a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <a href="forgetpass.html" style="text-decoration:underline">Forgot password ?</a>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Quantity/Update</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $view->getDisplayCartTable(); ?>
                            <td colspan="4" style="text-align:right"><strong>TOTAL</strong></td>
                            <td class="label label-important" style="display:block"> <strong> Php<?php echo (isset($_SESSION['partial_total']) ? number_format($_SESSION['partial_total'], 2) : 0.00); ?> </strong></td>
                        </tr>
                        </tbody>
                    </table>



                    <a href="products" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
                    <a href="login" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

                </div>
            </div></div>
    </div>

<?php
include 'includes/footer.php';
?>