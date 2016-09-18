<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 3:47
 */
class Marketing implements ScriptsInterface
{

    public function printScript()
    {
        echo "<script>

        $('#referral_graph').highcharts('StockChart',{
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Referral Graph'
            },
            yAxis: {
                title: {
                    text: 'Referral Count'
                }
            },
            legend: {
                enabled: false
            },
            rangeSelector: {
                selected: 1
            },

            series: [";
        $this->getModule()->printData();
        echo "]
        });

    </script>";
    }
    
    public function getModule(){
        $module = new MarketingModule();
        return $module;
    }
    
}