<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 3:47
 */
class ReferralChartScript implements ScriptsInterface
{

    public function printScript()
    {
        $this->printChart();
    }

    private function printChart(){
        echo '<script>
      $(document).ready(function(){
        var options = {
          legend: false,
          responsive: false
        };

        new Chart(document.getElementById("canvas1"), {
          type: "doughnut",
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",';
          $this->getModule()->printData();
          echo 'options: options
        });
      });
    </script>';
    }
    
    public function getModule(){
        $module = new ReferralChartModule();
        return $module;
    }
    
}