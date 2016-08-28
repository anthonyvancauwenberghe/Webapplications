<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 22/06/2016
 * Time: 19:00
 */

require_once '../libs/AutoLoader.php';

$core = new Core();
$core->setStartTime();
$login = new LoginSystem(Rank::PLAYER);

$template = new Template($login);
$scripts = new Scripts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico'/>

    <title>Home | NoxiousPs</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="#" class="site_title"><img src="images/footer-logo-small.png" style="height: 39px;">
                        <span><img src="images/logo.png" style="width: 151px;height: 31px;"></span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <?php $template->printMenuProfile(); ?>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <?php $template->printSidebar(); ?>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <?php $template->printFooterButtons(); ?>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <?php $template->printTopNavigation(); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <?php $template->printPlayerDashboard(); ?>
        <!-- /page content -->



        <!-- footer content -->
        <footer>
            <div class="pull-right">
                All Rights Reserved by - <a href="http://NoxiousPs.com">NoxiousPs</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>


<?php
$template->printDashboardScripts();
echo '<center><div class="loadtime"><h4>Page Generated in ' . $core->getPageLoadTime() . ' ms.</h4></div></center>';
?>
</body>
</html>