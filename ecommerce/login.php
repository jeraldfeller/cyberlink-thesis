<?php
include 'includes/header.php';
?>

    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="product_summary.html"><img src="themes/images/ico-cart.png" alt="cart">3 Items in your cart  <span class="badge badge-warning pull-right">$155.00</span></a></div>
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
                        <li class="active">Login</li>
                    </ul>
                    <h3> Login</h3>
                    <hr class="soft"/>

                    <div class="row">
                        <div class="span4">
                            <div class="well">
                                <h5>CREATE YOUR ACCOUNT</h5><br/>
                                Enter your e-mail address to create an account.<br/><br/><br/>
                                <form action="register">
                                    <div class="control-group">
                                        <label class="control-label" for="inputEmail0">E-mail address</label>
                                        <div class="controls">
                                            <input class="span3"  type="email" id="inputEmail0" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="controls">
                                        <button type="submit" class="btn block">Create Your Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="span1"> &nbsp;</div>
                        <div class="span4">
                            <div class="well">
                                <h5>ALREADY REGISTERED ?</h5>
                                <form>
                                    <div class="control-group">
                                        <label class="control-label" for="inputEmail1">Email</label>
                                        <div class="controls">
                                            <input class="span3"  type="text" id="inputEmail1" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputPassword1">Password</label>
                                        <div class="controls">
                                            <input type="password" class="span3"  id="inputPassword1" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn">Sign in</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div></div>
    </div>
    <!-- MainBody End ============================= -->

<?php
include 'includes/footer.php';
?>