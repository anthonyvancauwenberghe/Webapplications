<?php

abstract class LogsDisplay
{
    private $playerData;
    private $core;
    private $logsInput;
    protected $login;

    public function __construct($login=null) {
        $this->login=$login;
        $this->logsInput = $this->getLogsInput();
        $this->name = $this->getLogsInput()->getName();
    }

    protected function getName()
    {
        return $this->name;
    }
    
    abstract public function printLogTypeByPlayername();

    private function getPlayerData()
    {
        if (!isset($this->playerData)) {
            $this->playerData = new PlayerData();
        }
        return $this->playerData;
    }

    private function getLogsInput()
    {
        if (!isset($this->logsInput)) {
            $this->logsInput = new LogsInput();
        }
        return $this->logsInput;
    }
    
    public function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }
    
    protected function getLookupTitle(){
        return '<div class="x_title"><h2>' . $this->login->hasPermission(Rank::ADMINISTRATOR) ? $this->getAdminLookupTitle() : $this->getNormalLookupTitle() . '</h2>
                        <div class="clearfix"></div>
                    </div>';
    }
    

    private function getNormalLookupTitle()
    {
        $name = $this->getName();


        if (isset($name)) {
            return ucfirst($this->getLogType()) . '<small>' . $name . '</small>';
        } else {
            return ucfirst($this->getLogType()) . '<small>ALL</small>';
        }
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
            return ucfirst($this->getLogsInput()->getLogType()) . ' <small>' . $name . '</small> | ' . $ip . ' | ' . $mac;
        } else {
            return ucfirst($this->getLogsInput()->getLogType()) . '<small>ALL</small>';
        }
    }

    public function enterName()
    {
        echo '<h2>Please Enter A Playername</h2>';
    }

    

    public function printTODO(){
        echo '<h1> Still got to code this</h1>';
    }

    
    
}