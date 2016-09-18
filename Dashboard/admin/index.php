<?php
$path = parse_ini_file('path.ini');
require $path['path']."/libs/AutoLoader.php";

$core = new Core();
$core->setStartTime();
$login = new LoginSystem(Rank::OWNER);

$template = new Template($login);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel | NoxiousPs</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../css/custom.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <?php $template->printSidebarLogo(); ?>

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
        <div class="right_col" role="main">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="dashboard_graph">

                        <div class="row x_title">
                            <div class="col-md-6">
                                <h3>Marketing Graph </h3>
                            </div>
                        </div>

                        <div id="referral_graph" style="height: 400px; min-width: 310px"></div>


                        <div class="clearfix"></div>
                    </div>
                </div>
        </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="dashboard_graph">

                        <div class="row x_title">
                            <div class="col-md-6">
                                <h3>Wealth Graph </h3>
                            </div>
                        </div>

                        <div id="wealth_graph" style="height: 400px; min-width: 310px"></div>


                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            </div>
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

<?php $template->printAdminScripts(); ?>



<?php
echo '<center><div class="loadtime"><h4>Page Generated in ' . $core->getPageLoadTime() . ' ms.</h4></div></center>';
?>
</body>
</html>