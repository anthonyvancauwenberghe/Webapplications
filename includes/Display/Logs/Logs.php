<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 1:10
 */
class Logs
{
    private $name;
    private $logsInput;
    private $login;

    public function __construct($login)
    {
        $this->login = $login;
        $this->name = $login->getName();
    }

    private function getName()
    {
        return $this->name;
    }

    private function getLogin(){
        return $this->login;
    }
    
    private function getLogsInput()
    {
        if (!isset($this->logsInput)) {
            $this->logsInput = new LogsInput();
        }
        return $this->logsInput;
    }

    public function printLogs()
    {
        echo '<div class="right_col" role="main">
            <div class="">
                <div class="page-title">';
        $this->printPageTitle();
        $this->printLogsSearchBar();
        $this->printLogType();

        echo '</div>
            </div>
            </div>';
    }

    private function printLogType()
    {
        $name = $this->getName();
        $logType = $this->getLogsInput()->getLogType();
        $id = $this->getLogsInput()->getID();

        switch ($logType) {

            case null:
                break;

            case 'accountvalues':
                $accountValues = new AccountValues($this->getLogin());
                $accountValues->printLogTypeByPlayername();
                break;

            case 'trade':
                $trades = new Trades($this->getLogin());
                if (isset($name)) {
                    $trades->printLogTypeByPlayername();
                } elseif (isset($id)) {
                    $this->printTODO();
                } else {
                    $trades->enterName();
                }
                break;

            case 'death':
                $deaths = new Deaths($this->getLogin());
                if (isset($name)) {
                    $deaths->printLogTypeByPlayername();
                } elseif (isset($id)) {
                    $this->printTODO();
                } else {
                    $deaths->enterName();
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

    private function printTODO()
    {
        echo '<h1> Still got to code this</h1>';
    }


    private function printPageTitle()
    {
        echo '<div class="title_left">
                        <h3> Logs </h3>
                  </div>';
    }

    private function printLogsSearchBar()
    {
        echo '<div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input id="searchform" type="text" class="form-control" placeholder="Search for...">


                                <span class="input-group-btn">
                      <div class="btn-group open">
                                    <button id="logTypeButton" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="true"> <span id="type">Log Type</span> </button>
                                    <ul id="loglist" class="dropdown-menu">
                                        <li id="death"><a>Death Logs</a>
                                        </li>
                                        <li id="trade"><a>Trade Logs</a>
                                        </li>
                                        <li id="duel"><a>Duel Logs</a>
                                        </li>
                                        <li id="pickup-item"><a>Pickup-Item Logs</a>
                                        </li>
                                        <li id="kill"><a>Kill Logs</a>
                                        </li>
                                        <li id="drop-item"><a>Drop-Item Logs</a>
                                        </li>
                                        <li id="public-chat"><a>Public Chat Logs</a>
                                        </li>
                                        <li id="private-chat"><a>Private Chat Logs</a>
                                        </li>
                                        <li id="clan-chat"><a>Clan Chat Logs</a>
                                        </li>
                                        <li id="accountvalues"><a>Accountvalue Logs</a>
                                        </li>
                                    </ul>
                                </div>
                                  <button id="searchButton" class="btn btn-default" type="button">Search</button>
                    </span>
                            </div>
                        </div>
                    </div>';
    }

}