<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 0:34
 */
class Trades extends LogsDisplay
{
    public function printLogTypeByPlayername()
    {
        $tradeLogs = new TradeLogs();
        $cursor = $tradeLogs->getLogData($this->getName());

        echo '<thead>
                        <tr>
                          <th>TradeID</th>
                          <th>TimeStamp</th>
                          <th>Traded With</th>
                          <th>Trade Value GP (Mil)</th>
                          <th>Trade Value DP ($)</th>
                          <th>Trade Weighted Value</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        foreach ($cursor as $trade) {
            if ($trade['content']['user']['player-name'] == $this->getName()) {
                $name = $trade['content']['user-2']['player-name'];
            } else {
                $name = $trade['content']['user']['player-name'];
            }
            if (isset($trade)) {
                echo '<tr>';
                echo '<td><a href="../logs.php?logtype=trade&id=' . $trade["_id"] . '">' . $trade["_id"] . '</a></td>';
                echo '<td>' . $this->getCore()->convertToTimeWithFormat($trade['time']) . '</td>';
                echo '<td>' . $name . '</td>';
                echo '<td>TODO</td>';
                echo '<td>TODO</td>';
                echo '<td>TODO</td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
    }

}