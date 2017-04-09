<?php
require 'Model/Init.php';
require 'View/FormElements.php';
$view = new FormElements();
if(isset($_SESSION['cart'])){
    $itemCount = count($_SESSION['cart']);
    $partialTotal = number_format(bcdiv($_SESSION['partial_total'], 1, 2), 2);
}else{
    $itemCount = 0;
    $partialTotal = 0.00;
}
//unset($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cyber Link Copu Sales</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--Less styles -->
    <!-- Other Less css file //different less files has different color scheam
     <link rel="stylesheet/less" type="text/css" href="themes/less/simplex.less">
     <link rel="stylesheet/less" type="text/css" href="themes/less/classified.less">
     <link rel="stylesheet/less" type="text/css" href="themes/less/amelia.less">  MOVE DOWN TO activate
     -->
    <!--<link rel="stylesheet/less" type="text/css" href="themes/less/bootshop.less">
    <script src="themes/js/less.js" type="text/javascript"></script> -->

    <!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
    <!-- Bootstrap style responsive -->
    <link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
    <link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->
    <link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
    <style type="text/css" id="enject"></style>
    <script src="themes/js/jquery.js" type="text/javascript"></script>
</head>
<body>
<div id="header">
    <div class="container">
        <div id="welcomeLine" class="row">
            <div class="span6">Welcome!<strong> <?php echo (isset($_SESSION['is_logged']) == true ? $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] : 'User'); ?></strong></div>
            <div class="span6">
                <div class="pull-right">
                    <span class="btn btn-mini">Php<span id="headerTotalPartial"><?php echo $partialTotal; ?></span></span>
                    <a href="cart"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ <span id="headerItemCount"><?php echo $itemCount; ?></span>  ] Items in your cart </span> </a>
                    <?php if(isset($_SESSION['is_logged']) == true){ ?>
                    <a href="my-orders"><span class="btn btn-mini btn-primary"><i class="icon-file icon-white"></i> My Orders </span> </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Navbar ================================================== -->
        <div id="logoArea" class="navbar">
            <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-inner">
                <a class="brand" href="index"><img src="themes/images/logo.png" alt="Bootsshop"/></a>
                <form class="form-inline navbar-search" method="post" action="products.html" >
                    <input id="srchFld" class="srchTxt" type="text" />
                    <select class="srchTxt">
                        <option>All</option>
                        <?php
                            echo $view->getDisplaySelectCategories();
                        ?>
                    </select>
                    <button type="submit" id="submitButton" class="btn btn-primary">Go</button>
                </form>
                <ul id="topMenu" class="pull-right" style="list-style: none; padding-top: 20px;">
                    <li class="">
                        <?php if(isset($_SESSION['is_logged']) == true) {
                            echo '<a href="logout.php"><button class="btn btn-warning">Logout</button></a>';
                        }else{
                            echo '<button class="btn btn-large btn-success" data-toggle="modal" data-target="#modalLogin">Login</button>';
                            echo '<a href="register"><button class="btn btn-large btn-success">Register</button></a>';
                        }
                        ?>
                        <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                        </button>
                                        <h2 class="modal-title" id="myModalLabel">Login</h2>
                                    </div>
                                        <div class="modal-body">
                                                <div id="loginMsg"></div>
                                                <div class="col-lg-12">
                                                    <input type="text" placeholder="Email" id="loginEmail" name="loginEmail" class="form-control" required="required" style="width: 90%;">
                                                </div>
                                                <div class="col-lg-12">
                                                    <input type="password" placeholder="Password" id="loginPassword" name="loginPassword" class="form-control" required="required" style="width: 90%;">
                                                </div>

                                        </div>

                                        <div class="modal-footer">
                                            <span id="proccessing" style="display: none;">Processing....</span>
                                            <button class="btn btn-primary" id="login"/>Login</button>
                                            <a href="register"><button class="btn btn-success" id="register"/>Create account</button></a>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('ready', function(){
        $('#login').on('click', function(){
            $('#proccessing').css('display', 'inline');
            $('#login').css('display', 'none');
            $('#register').css('display', 'none');

            $data = {
                email: $('#loginEmail').val(),
                password: $('#loginPassword').val()
            }
            loginAction($data);
        });
    });
</script>
<!-- Header End====================================================================== -->
