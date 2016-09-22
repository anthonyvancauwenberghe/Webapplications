<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 18/09/2016
 * Time: 12:25
 */
class ReferralChartModule
{
    
    public function printData($week=null, $month=null, $year=null)
    {
        $referralArray = $this->getData($week, $month, $year);

            echo'data: {
            labels: [';

        foreach ($referralArray as $document) {
            echo '"'. $document['_id'] .'",';
        }

            echo '],
            datasets: [{
              data: [';

        foreach ($referralArray as $document) {
            echo $document['amount'] .',';
        }

        echo'],
              backgroundColor: [
                "#BDC3C7",
                "#9B59B6",
                "#E74C3C",
                "#26B99A",
                "#3498DB",
                "#cd157b",
                "#2f8da0",
                "#75d474",
                "#36CAAB",
                "#cd157b"
              ],
              hoverBackgroundColor: [
                "#CFD4D8",
                "#B370CF",
                "#E95E4F",
                "#36CAAB",
                "#49A9EA",
                "#BDC3C7",
                "#9B59B6",
                "#E74C3C",
                "#26B99A",
                "#3498DB"
              ]
            }]
          },';
    }

    public function printWidget($week=null, $month=null, $year=null){
        echo '<div class="row">

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  '. $this->getReferralTitle($week, $month, $year) .'
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">';

        $referralArray = $this->getData($week, $month, $year);
        $total = 0;

        foreach ($referralArray as $document) {
            $total = $total + $document['amount'];
        }
        $i=0;

        foreach ($referralArray as $document) {

            $percent = round(($document['amount']/$total)*100,0);
            echo '<div class="widget_summary">
                    <div class="w_left w_25">
                      <span>'. ucfirst($document['_id']) .'</span>
                    </div>
                    <div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="'. $percent .'" aria-valuemin="0" aria-valuemax="100" style="width: '. $percent .'%;">
                          <span class="sr-only">'. $document['amount'] .' Refs</span>
                        </div>
                      </div>
                    </div>
                    <div class="w_right w_20">
                      <span>'. $document['amount'] .'</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>';
            $i++;

            if($i>4)
            break;

        }
        echo '</div>
              </div>
            </div>';


    }

    public function printChart($week=null, $month=null, $year=null){

        echo '<div class="col-md$week=null, $month=null, $year=null-4 col-sm-4 col-xs-12">
              <div class="x_panel tile fixed_height_320 overflow_hidden">
                <div class="x_title">
                '. $this->getReferralTitle($week, $month, $year) .'
                <div class="clearfix"></div>
                </div>
                <div class="x_content" style="text-align: center;">
                        <canvas id="canvas1" height="200" width="200" style="margin: 15px 10px 10px 0px; width: 200px; height: 200px;"></canvas>

                </div>
              </div>
            </div>';
    }

   private function getReferralTitle($week=null, $month=null, $year=null){
       if(isset($week)){
           return '<h2>Referrals This Week</h2>';
       }
       elseif(isset($month)){
           return '<h2>Referrals This Month</h2>';
       }
       elseif(isset($year)){
           return '<h2>Referrals This Year</h2>';
       }
       else {
           return '<h2>Referrals All Time</h2>';
       }
}


    private function getData($week=null, $month=null, $year=null){
        $data = new ReferralChartData();
        $referralArray = $data->getCursor($week,$month,$year)->toArray();
        return $referralArray;
    }


    
    
    
}