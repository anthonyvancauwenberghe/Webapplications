<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 0:12
 */
class DeathLogs extends Data implements LogsData
{

    public function getLogData($name = null)
    {
        $query = array('$and' => array(array('log-type' => 'death-log'),array('content.user.player-name' => $name)));

        $cursor = $this->find(Collection::LOGS, $query);
        return $cursor;
    }
    public function getLogDataByID($id)
    {
        $query = array('$and' => array(array('log-type' => 'death-log'),array('_id'  => new MongoDB\BSON\ObjectId($id))));

        $cursor = $this->find(Collection::LOGS, $query);
        return $cursor;
    }

}