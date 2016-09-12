<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 3:47
 */
class Marketing
{

    public function getReferralScript()
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
        $this->buildGraphArray();
        echo "]
        });

    </script>";
    }


    private function extractReferralData($document)
    {
        $refData = array();
        $i = 0;
        foreach ($document['amounts'] as $data) {

            //$time = 'Date.UTC(' . $data['year'] . ',' . $data['month'] . ',' . $data['day'] . ')';
            $time = $this->getUnixTimestamp($data['day'], $data['month'], $data['year']);
            $count = $data['amount'];
            $array = [$time, $count];

            $refData[$i] = $array;
            $i++;

        }

        return json_encode($refData);
    }

    private function buildGraphArray()
    {
        $data = new MarketingInfo();
        $referralArray = $data->getMarketingData();

        foreach ($referralArray as $document) {
            echo '{';
            echo 'type: "spline",';
            echo 'name: "'. $document['_id'] .'",';
            echo 'data: '. $this->extractReferralData($document) .',';
            echo '},';
            //$graph['type'] = 'spline';
            //$graph['name'] = $document['_id'];
            //$graph['data'] = $this->extractReferralData($document);

            //$graphData[$i] = $graph;
            //$i++;
        }

        //return json_encode($graphData);
    }

    private function getUnixTimestamp($day, $month, $year){
        return (int) 1000 * strtotime($day . '-' . $month . '-' . $year);
    }

}