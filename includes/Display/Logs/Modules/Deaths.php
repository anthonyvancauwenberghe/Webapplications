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

        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title"><h2>' . $this->login->hasPermission(Rank::ADMINISTRATOR) ? $this->getAdminLookupTitle() : $this->getLookupTitle() . '</h2>
                        <div class="clearfix"></div>
                    </div>
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"><thead>
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
                echo '<td>' . $death['content']['killer'] . '</td>';
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
        echo '</tbody></table>

                        </div>
                    </div>
                </div>';
    }

}