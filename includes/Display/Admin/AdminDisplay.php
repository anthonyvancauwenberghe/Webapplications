<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 3:47
 */
class AdminDisplay
{
    private $referralChartModule;
    private $core;

    private function getCore(){
        return new Core();
}
    public function printContent(){

        echo '<div class="right_col" role="main">';

            $this->printRefGraph();
            $this->printWealthGraph();
            $this->getReferralChartModule()->printWidget(null,null,$this->getCore()->getYearNumber());

            $this->getReferralChartModule()->printChart();
        $this->getReferralChartModule()->printWidget($this->getCore()->getWeekNumber(),null,null);
            echo '
            </div>
            </div>';
    }

    public function printAdminScripts(){
        $scripts = new AdminScripts();
        $scripts->printScripts();
    }

    private function getReferralChartModule(){
        if(!isset($this->referralChartModule)){
            $this->referralChartModule = new ReferralChartModule();
        }
        return $this->referralChartModule;
    }

    private function printRefGraph(){
        echo '<div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="dashboard_graph">

                        <div class="row x_title">
                            <div class="col-md-6">
                                <h3>Referral Graph </h3>
                            </div>
                        </div>

                        <div id="referral_graph" style="height: 400px; min-width: 310px"></div>


                        <div class="clearfix"></div>
                    </div>
                </div>
        </div>';
    }

    private function printWealthGraph(){
        echo '<div class="row">
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
            </div>';
    }

}