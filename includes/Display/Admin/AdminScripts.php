<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 3:47
 */
class AdminScripts extends Scripts
{

    public function printScripts(){
        $this->printBaseScripts();
        $this->printHighStock();
        $this->printChart();
        $this->printNProgress();
        $this->printFastClick();


        $this->printReferralChartScript();
        $this->printReferralGraphScript();
        $this->printServerWealthGraphScript();

    }

    private function printReferralGraphScript(){
        $marketing = new ReferralGraphScript();
        $marketing->printScript();
    }

    private function printServerWealthGraphScript(){
        $wealth = new WealthGraphScript();
        $wealth->printScript();
    }

    private function printReferralChartScript(){
        $ReferralChartScript = new ReferralChartScript();
        $ReferralChartScript->printScript();
    }


}