<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 0:33
 */
class AccountValues extends LogsDisplay 
{
    public function printLogTypeByPlayername()
    {
        $playerValuesArray = $this->getPlayerData()->getAccountvalues();

        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title"><h2>' . $this->getLookupTitle() . '</h2>
                        <div class="clearfix"></div>
                    </div>
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"><thead>
                        <tr>
                          <th>Rank</th>
                          <th>Playername</th>
                          <th>GP Value (Mil)</th>
                          <th>DP Value ($)</th>
                          <th>Weighted Acc Value</th>
                        </tr>
                      </thead>
                      
                      <tbody>';
        $i = 1;
        foreach ($playerValuesArray as $key => $playerValue) {

            if (isset($playerValue)) {
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $playerValue["name"] . '</td>';
                echo '<td>' . $playerValue["gp"] . '</td>';
                echo '<td>' . $playerValue["dp"] . '</td>';
                echo '<td>' . $playerValue["accworth"] . '</td>';
                echo '</tr>';
            }
            $i++;
        }
        echo '</tbody></table>

                        </div>
                    </div>
                </div>';
    }

}