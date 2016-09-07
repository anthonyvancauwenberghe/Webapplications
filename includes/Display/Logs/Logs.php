<?php

class Logs
{
    private $playerData;
    private $logsData;
    private $core;
    private $login;

    public function __construct($login) {
        $this->login=$login;
    }

    public function printLogs()
    {
        $logType = $this->getLogType();
        $name = $this->getName();
        $id = $this->getID();
        
        switch ($logType){
            
            case null:
                break;

            case 'accountvalues':
                $this->printAccountValueLogs();
                break;
            
            case 'trade':
                if(isset($name)){
                    $this->printTradeLogs();
                }
                elseif(isset($id)){
                    echo '<h1>TODO</h1>';
                }
                else{
                    $this->enterName();
                }
                break;
            
            case 'death':
                if(isset($name)){
                    $this->printDeathLogs();
                }
                elseif(isset($id)){
                    echo '<h1>TODO</h1>';
                }
                else{
                    $this->enterName();
                }
                break;
            
            case 'duel':
                $this->printDuelLogs();
                break;
            
            default:
                echo $this->TODO();
        }
    }

    private function getLogType()
    {
        if (isset($_GET["logtype"])) {
            return (string)$_GET["logtype"];
        } else {
            return null;
        }

    }

    private function getName()
    {
        if (isset($_GET["name"])) {
            return (string)$this->getCore()->normalizeUsername($_GET["name"]);
        } else {
            return null;
        }
    }

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }

    private function getID()
    {
        if (isset($_GET["id"])) {
            return (string)$_GET["id"];
        } else {
            return null;
        }

    }

    private function printAccountValueLogs()
    {
        $this->getPlayerData();

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

    private function getPlayerData()
    {
        if (!isset($this->playerData)) {
            $this->playerData = new PlayerData();
        }
        return $this->playerData;
    }

    private function getLookupTitle()
    {
        $name = $this->getName();


        if (isset($name)) {
            return ucfirst($this->getLogType()) . '<small>' . $name . '</small>';
        } else {
            return ucfirst($this->getLogType()) . '<small>ALL</small>';
        }
    }

    private function printTradeLogs()
    {


        $cursor = $this->getLogsData()->getTradeLogsData($this->getName());

        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title"><h2>' . $this->getLookupTitle() . '</h2>
                        <div class="clearfix"></div>
                    </div>
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"><thead>
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
        echo '</tbody></table>

                        </div>
                    </div>
                </div>';
    }

    private function getLogsData()
    {
        if (!isset($this->logsData)) {
            $this->logsData = new LogsData();
        }
        return $this->logsData;
    }

    private function enterName()
    {
        echo '<h2>Please Enter A Playername</h2>';
    }

    private function printDeathLogs(){
        $cursor = $this->getLogsData()->getDeathLogsData($this->getName());

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
        }
        echo '</tbody></table>

                        </div>
                    </div>
                </div>';
    }

    private function getAdminLookupTitle()
    {
        $name = $this->getName();
        $ip = $this->getPlayerData()->getPlayerIP($name);
        $mac = $this->getPlayerData()->getPlayerMAC($name);

        if (!isset($ip))
            $ip = 'unable to retrieve ip';

        if (!isset($mac))
            $mac = 'unable to retrieve mac';

        if (isset($name)) {
            return ucfirst($this->getLogType()) . '<small>' . $name . '</small> | ' . $ip . ' | ' . $mac;
        } else {
            return ucfirst($this->getLogType()) . '<small>ALL</small>';
        }
    }

    public function printDuelLogs(){
        echo $this->TODO();
    }

    private function TODO(){
        return '<h1> Still got to code this shit</h1>';
    }

    public function getPageTitle()
    {
        return ucwords($this->getLogType()) . ' Logs';
    }
    
}