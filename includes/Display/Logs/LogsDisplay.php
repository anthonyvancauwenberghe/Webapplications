<?php

abstract class LogsDisplay
{
    private $playerData;
    private $core;
    protected $login;

    public function __construct($login=null) {
        $this->login=$login;
    }
    
    abstract public function printLogTypeByPlayername();

    public function printLogs()
    {
        $logType = $this->getLogType();
        $name = $this->getName();
        $id = $this->getID();
        
        switch ($logType){
            
            case null:
                break;

            case 'accountvalues':
                $accountValues = new AccountValues();
                $accountValues->printLogTypeByPlayername();
                break;
            
            case 'trade':
                $trades = new Trades();
                if(isset($name)){
                    $trades->printLogTypeByPlayername();
                }
                elseif(isset($id)){
                    echo '<h1>TODO</h1>';
                }
                else{
                    $this->enterName();
                }
                break;
            
            case 'death':
                $deaths = new Deaths();
                if(isset($name)){
                    $deaths->printLogTypeByPlayername();
                }
                elseif(isset($id)){
                    echo '<h1>TODO</h1>';
                }
                else{
                    $this->enterName();
                }
                break;
            
            case 'duel':
                $duels = new Duels();
                $duels->printLogTypeByPlayername();
                break;
            
            default:
                $this->printTODO();
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

    protected function getName()
    {
        if (isset($_GET["name"])) {
            return (string)$this->getCore()->normalizeUsername($_GET["name"]);
        } else {
            return null;
        }
    }

    public function getCore()
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

    protected function getPlayerData()
    {
        if (!isset($this->playerData)) {
            $this->playerData = new PlayerData();
        }
        return $this->playerData;
    }

    protected function getLookupTitle()
    {
        $name = $this->getName();


        if (isset($name)) {
            return ucfirst($this->getLogType()) . '<small>' . $name . '</small>';
        } else {
            return ucfirst($this->getLogType()) . '<small>ALL</small>';
        }
    }

    private function enterName()
    {
        echo '<h2>Please Enter A Playername</h2>';
    }

    protected function getAdminLookupTitle()
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

    protected function printTODO(){
        echo '<h1> Still got to code this</h1>';
    }

    protected function getPageTitle()
    {
        return ucwords($this->getLogType()) . ' Logs';
    }
    
}