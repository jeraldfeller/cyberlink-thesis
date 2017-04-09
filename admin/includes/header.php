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


    <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />


    <!-- select2 -->
    <link href="css/select/select2.min.css" rel="stylesheet">
    <!-- switchery -->
    <link rel="stylesheet" href="css/switchery/switchery.min.css" />

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">





    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>


    <!-- input file style -->

    <script src="js/bootstrap-filestyle.js"></script>



    <!--[if lt IE 9]>
    <script src="assets/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="css/tags/bootstrap-tagsinput.css" rel="stylesheet">

    <!-- switch -->
    <link href="css/switch/bootstrap-switch.min.css" rel="stylesheet">


</head>


<body class="nav-md">

<div class="container body">


    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="index" class="site_title"><img src="images/logo_icon.png"  alt="Cyber Link Compu Sales"></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="images/user.png" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span><?php echo $designation; ?></span>
                        <h2><?php echo $full_name; ?></h2>

                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="pos"><i class="fa fa-shopping-cart"></i> POS </a>
                                </li>
                                <li><a href="products"><i class="fa fa-archive"></i> Products </a>
                                </li>
                                <li><a href="categories"><i class="fa fa-sitemap"></i> Categories </a>
                                </li>
                                <li><a href="supplier"><i class="fa fa-truck"></i> Supplier </a>
                                </li>
                                <li><a href="borrowed-items"><i class="fa fa-cubes"></i> Borrowed Items </a>
                                </li>
                                <li><a href="customers"><i class="fa fa-users"></i> Customers </a>
                                </li>
                                <li><a href="orders"><i class="fa fa-shopping-cart"></i> Orders </a>
                                </li>
                                <li><a href="reports"><i class="fa fa-bar-chart"></i> Reports </a>
                                </li>
                                <li><a href="logout"><i class="fa fa-power-off"></i> Logout </a>
                                </li>

                            </ul>

                    </div>

                </div>
                <!-- /sidebar menu -->

            </div>
        </div>

        <!-- /top navigation -->
