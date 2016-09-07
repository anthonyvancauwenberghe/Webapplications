<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 0:10
 */
class TradeLogs extends Data implements LogsData
{

    public function getLogData($name = null)
    {
        $query = array('$and' => array(array('log-type' => 'trade-log'), array('$or' => array(array('content.user.player-name' => $name), array('content.user-2.player-name' => $name)))));

        $cursor = $this->find(Collection::LOGS, $query);
        return $cursor;
    }

}