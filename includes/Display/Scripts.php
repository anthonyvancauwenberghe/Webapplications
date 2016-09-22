<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 28/08/2016
 * Time: 14:15
 */
abstract class Scripts
{
    abstract public function printScripts();

    protected function printBaseScripts()
    {
        $this->printJQuery();
        $this->printBootstrap();
        $this->printCustom();
    }

    protected function printHighStock(){
        echo '<script src="../js/highstock/highstock.js"></script>
                <script src="../js/highstock/modules/exporting.js"></script>';
    }

    protected function printFastClick(){
        echo '<!-- FastClick -->
                <script src="../vendors/fastclick/lib/fastclick.js"></script>';
    }

    protected function printNProgress(){
        echo '<!-- NProgress -->
                <script src="../vendors/nprogress/nprogress.js"></script>';
    }

    protected function printChart(){
        echo '<!-- Chart.js -->
                <script src="../vendors/Chart.js/dist/Chart.min.js"></script>';
    }

    protected function printGauge(){
        echo '<!-- gauge.js -->
                <script src="../vendors/gauge.js/dist/gauge.min.js"></script>';
    }

    private function printJQuery(){
        echo '
            <!-- jQuery -->
            <script src="../vendors/jquery/dist/jquery.min.js"></script>';
    }

    private function printBootstrap(){
        echo '<!-- Bootstrap -->
                <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

             <!-- Bootstrap-Progressbar.js -->
                <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>';
    }

    private function printCustom(){
       echo ' <!-- Custom Theme Scripts -->
                <script src="../js/custom.js"></script>';
    }



}