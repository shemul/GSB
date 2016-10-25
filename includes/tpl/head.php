<?php
global $hooks;
global $menu_array;
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="image/png">
        <title><?php $hooks->do_action("the_title"); ?> - GOLDEN STAR</title>

        <!--icheck-->
        <link href="/assets/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
        <link href="/assets/js/iCheck/skins/square/square.css" rel="stylesheet">
        <link href="/assets/js/iCheck/skins/square/red.css" rel="stylesheet">
        <link href="/assets/js/iCheck/skins/square/blue.css" rel="stylesheet">

        <!--dashboard calendar-->
        <link href="/assets/css/clndr.css" rel="stylesheet">

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="/assets/js/morris-chart/morris.css">

        <!--common-->
        <link href="/assets/css/style.css" rel="stylesheet">
        <link href="/assets/css/style-responsive.css" rel="stylesheet">
        <link href="/assets/css/responsivetabel.css" rel="stylesheet">

        <script src="/assets/js/jquery-1.10.2.min.js"></script>

<?php $hooks->do_action("global_css"); ?>



        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="sticky-header">
        <section>
            <!-- left side start-->
            <div class="left-side sticky-left-side">

                <!--logo and iconic logo start-->
                <div class="logo">
                    <a href="/dashboard"><img src="/assets/logo.png" alt="" style="height:100%;"></a>
                </div>
                <!--logo and iconic logo end-->

                <div class="left-side-inner">

                    <!--sidebar nav start-->
<?php menu_render($menu_array); ?>
                    <!--sidebar nav end-->

                </div>
            </div>
            <div class="main-content" >
                <div class="header-section">
                    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
                    <div class="menu-right">
                        <ul class="notification-menu">
                            <li>
<?php if (isset($_SESSION["godmode"]["status"])) { ?>
                                    <a href="/godmode-off" class="btn btn-default dropdown-toggle">
                                        <i class="fa fa-lock"></i> Back as Admin
                                    </a>
<?php } else { ?>
                                    <a href="/logout" class="btn btn-default dropdown-toggle">
                                        <i class="fa fa-lock"></i> Secure Logout
                                    </a>
<?php } ?>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="page-heading">
                    <h3>
<?php $hooks->do_action("the_title"); ?>
                    </h3>
                    <!-- <div class="state-info">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="summary">
                                    <span>Hello, Welcome</span>
                                    <h3><?php // echo strtoupper($_SESSION["uname"]); ?></h3>
                                </div>
                                <div id="income" class="chart-bar"></div>
                            </div>
                        </section>
                        <section class="panel">
                            <div class="panel-body">
                                <div class="summary">
                                    <span>Register Funds</span>
                                    <h3 class="red-txt"><?php //echo ($_SESSION["role"] == "1" ? "$" . current_register_fund() : "UNLIMITED"); 
                                    //echo "NULL";
                                    ?></h3>
                                </div>
                                <div id="income" class="chart-bar"></div>
                            </div>
                        </section>
                        <section class="panel">
                            <div class="panel-body">
                                <div class="summary">
                                    <span>Available Funds</span>
                                    <h3 class="green-txt"><?php //echo ($_SESSION["role"] == "1" ? "$" . current_fund() : "UNLIMITED"); 
                                    //echo "NULL";
                                    ?></h3>
                                </div>
                                <div id="expense" class="chart-bar"></div>
                            </div>
                        </section>
                    </div> -->
                </div>
                <div class="wrapper">