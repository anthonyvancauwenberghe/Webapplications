<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 18/09/2016
 * Time: 12:24
 */
class WealthGraphScript implements ScriptsInterface
{

    public function printScript()
    {
        echo "<script>

        $('#wealth_graph').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Wealth Graph Evolution'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'GP'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'spline',
                name: 'GP (/mil)',
                data: " . $this->getModule()->getGPWealthData() . "
            },
            {
                type: 'spline',
                name: 'DP (per 100)',
                data: " . $this->getModule()->getDPWealthData() . "
            }]
        });

    </script>";
    }

    public function getModule(){
        $module = new WealthModule();
        return $module;
    }

}