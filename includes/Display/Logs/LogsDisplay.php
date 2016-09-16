<?php

abstract class LogsDisplay
{

    private $core;
    private $logsInput;
    private $name;
    private $id;

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
    
    protected function getID(){
        if(!isset($this->id)){
            $this->id = $this->getLogsInput()->getID();
        }
        return $this->id;
    }

    private function getLookupTitle(){
        return '<div class="x_title"><h2>' . $this->getNormalLookupTitle() . '</h2>
                        <div class="clearfix"></div>
                    </div>';
    }

    protected function printStartLogTable(){
        echo'<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
    ' . $this->getLookupTitle() . '
                        <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
    }

    protected function printEndLogTable(){
        echo '</table>

                        </div>
                    </div>
                </div>';
    }

    private function getNormalLookupTitle()
    {
        $name = $this->getName();
        if (isset($name)) {
            return ucfirst($this->getLogsInput()->getLogType()) . '<small>' . $name . '</small>';
        } else {
            return ucfirst($this->getLogsInput()->getLogType()) . '<small>ALL</small>';
        }
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