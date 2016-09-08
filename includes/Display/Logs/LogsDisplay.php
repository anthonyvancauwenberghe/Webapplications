<?php

abstract class LogsDisplay
{

    private $core;
    private $logsInput;
    private $name;

    abstract public function printLogTypeByPlayername();
    
    private function getLogsInput()
    {
        if (!isset($this->logsInput)) {
            $this->logsInput = new LogsInput();
        }
        return $this->logsInput;
    }

    protected function getName()
    {
        if(!isset($this->name)){
            $this->name = $this->getLogsInput()->getName();
        }
        return $this->name;
    }
    
    protected function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }

    protected function printTODO(){
        echo '<h1> Still got to code this</h1>';
    }

    
    
}