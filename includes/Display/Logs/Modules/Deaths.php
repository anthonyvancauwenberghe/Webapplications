<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 0:34
 */
class Deaths extends LogsDisplay
{
    public function printLogTypeByPlayername()
    {
        $deathLogs = new DeathLogs();
        $cursor = $deathLogs->getLogData($this->getName());

        echo '<thead>
                        <tr>
                          <th>DeathID</th>
                          <th>TimeStamp</th>
                          <th>Killed By</th>
                          <th>Items Lost</th>
                          <th>Items Kept</th>
                          <th>Weighted AccountValue Lost (Mil)</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        foreach ($cursor as $death) {

            if (isset($death)) {
                echo '<tr>';
                echo '<td><a href="../logs.php?logtype=death&id=' . $death["_id"] . '">' . $death["_id"] . '</a></td>';
                echo '<td>' . $this->getCore()->convertToTime($death['time']) . '</td>';
                echo '<td>' . $death['content']['user']['player-name'] . '</td>';
                echo '<td>' . count($death['content']['items-lost']) . '</td>';
                echo '<td>' . count($death['content']['items-kept']) . '</td>';
                echo '<td>TODO</td>';
                echo '</tr>';
            }
            else {
                echo '<tr>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
    }

    public function printLogTypeByID($id)
    {
        $deathLogs = new DeathLogs();
        $cursor = $deathLogs->getLogData($id);

        echo '<thead>
                        <tr>
                          <th>ItemID</th>
                          <th>ItemName</th>
                          <th>Amount Dropped</th>
                          <th>Drop Value</th>
                          <th>Weighted AccountValue Lost (Mil)</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        foreach ($cursor['content']['items-lost'] as $item) {

            if (isset($item)) {
                echo '<tr>';
                echo '<td><a href="../logs.php?logtype=item&id=' . $item["itemId"] . '">' . $item["itemId"] . '</a></td>';
                echo '<td> TODO </td>';
                echo '<td>' . $item['amount'] . '</td>';
                echo '<td>TODO</td>';
                echo '<td>TODO</td>';
                echo '</tr>';
            }
            else {
                echo '<tr>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
    }

}