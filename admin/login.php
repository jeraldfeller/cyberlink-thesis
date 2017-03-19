<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cyber Link Compu Sales</title>

    <!-- [favicon] begin -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="fav_icon.ico" />
    <!-- [favicon] end -->

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

    <!--[if lt IE 9]>
    <script src="assets/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="background:#F7F7F7;">

<div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper" class="">
        <div id="login" class="animate form">
            <section class="login_content">
                <?php


                if(isset($_GET['msg'])){
                    echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                         Invalid Email or Password.
                          </div>';
                }

                ?>
                <form action="login-function" method="post">
                    <h1>Login Form</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="User Name" name="userName" id="userName" required="" />
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="" />
                    </div>
                    <div style="text-align:center"><span id="spinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                    <div>

                        <input type="submit" class="btn btn-default submit" value="Log in" id="send" onClick="loadSpinner(this, 'show', '#spinner');">

                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />
                        <div>
                            <h1><img src="images/logo_icon.png" alt="Cyber Link Compu Sales"></h1>
                            <p>©2016 All Rights Reserved. Cyber Link Compu Sales. <small>computer sales and repairs</small></p>
                        </div>
                    </div>
                </form>
                <!-- form -->
            </section>
            <!-- content -->
        </div>

    </div>
</div>

</body>

</html>


<script src="js/common.js"></script>