<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 0:34
 */
class ItemDrops extends LogsDisplay
{
    public function printLogTypeByPlayername()
    {
        $itemDrops = new ItemDropLogs();
        $cursor = $itemDrops->getLogData($this->getName());

        echo '<thead>
                        <tr>
                          <th>TimeStamp</th>
                          <th>Location</th>
                          <th>ItemID</th>
                          <th>Item Name</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        foreach ($cursor as $drop) {

            if (isset($drop)) {
                echo '<tr>';
                echo '<td>' . $this->getCore()->convertToTime($drop['time']) . '</td>';
                if(isset($drop['content']['position'])){
                    echo '<td>' . $drop['content']['position']['x'] . ' ' . $drop['content']['position']['y'] . ' ' . $drop['content']['position']['z'] . '</td>';
                }
                else {
                    echo '<td>Not Available</td>';
                }

                echo '<td>' . count($drop['content']['item-id']) . '</td>';
                echo '<td>TODO</td>';
                echo '<td>' . count($drop['content']['amount']) . '</td>';
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