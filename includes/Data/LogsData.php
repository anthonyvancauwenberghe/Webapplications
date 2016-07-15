<?php
require_once('../libs/AutoLoader.php');

class LogsData extends Data
{
    public function getTradeLogsData($name = null)
    {
        //$query = array(array('$and' =>array('log-type' => 'trade-log'), array('$or' => array(array('content.user.player-name' => $name), array('content.user-2.player-name' => $name)))));

        $query = array('$and' => array('log-type' => 'trade-log'), array('$or' => array(array('content.user.player-name' => $name), array('content.user-2.player-name' => $name))));

        $cursor = $this->find(Collection::LOGS, $query);
        return $cursor;
    }
}

