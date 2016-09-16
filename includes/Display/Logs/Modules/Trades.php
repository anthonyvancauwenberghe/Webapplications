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
        $this->printStartLogTable();
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
        $this->printEndLogTable();
    }

    public function printLogTypeByID(){
        $tradeLogs = new TradeLogs();
        $cursor = $tradeLogs->getLogDataByID($this->getID())->toArray();
        $player1 = $cursor[0]['content']['user'];
        $player2 = $cursor[0]['content']['user-2'];
                
        echo'<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                ' . $player1['player-name'] . '
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
        echo '<thead>
                        <tr>
                          <th>ItemID</th>
                          <th>Item Name</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        foreach ($player1['items'] as $item) {
            if (isset($item)) {
                echo '<tr>';
                echo '<td>' . $item['itemId'] . '</td>';
                echo '<td>TODO</td>';
                echo '<td>' . $item['amount'] . '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
        $this->printEndLogTable();
        
        echo'<br><br><div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                ' . $player2['player-name'] . '
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
        echo '<thead>
                        <tr>
                          <th>ItemID</th>
                          <th>Item Name</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        foreach ($player2['items'] as $item) {
            if (isset($item)) {
                echo '<tr>';
                echo '<td>' . $item['itemId'] . '</td>';
                echo '<td>TODO</td>';
                echo '<td>' . $item['amount'] . '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
        $this->printEndLogTable();
    }

}