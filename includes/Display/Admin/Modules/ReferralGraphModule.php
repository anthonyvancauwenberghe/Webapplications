<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 18/09/2016
 * Time: 12:25
 */
class ReferralGraphModule
{
    
    public function printData()
    {
        $referralArray = $this->getData();

        foreach ($referralArray as $document) {
            echo '{';
            echo 'type: "spline",';
            echo 'name: "'. $document['_id'] .'",';
            echo 'data: '. $this->extractReferralData($document) .',';
            echo '},';
        }
    }
    
    public function getData(){
        $data = new ReferralGraphData();
        $referralArray = $data->getCursor()->toArray();
        return $referralArray;
    }

    private function extractReferralData($document)
    {
        $refData = array();
        $i = 0;
        foreach ($document['amounts'] as $data) {
            $time = $this->getUnixTimestamp($data['day'], $data['month'], $data['year']);
            $count = $data['amount'];
            $array = [$time, $count];

            $refData[$i] = $array;
            $i++;

        }

        return json_encode($refData);
    }

    private function getUnixTimestamp($day, $month, $year){
        date_default_timezone_set('Europe/Brussels');
        return (int) 1000 * strtotime($day . '-' . $month . '-' . $year);
    }
    
    
    
}