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
        $accountValues = new AccountValueLogs();
        $playerValuesArray = $accountValues->getLogData();
        $this->printStartLogTable();
        echo '<thead>
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
        echo '</tbody>';
        $this->printEndLogTable();
    }

}