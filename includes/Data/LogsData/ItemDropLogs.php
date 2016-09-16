<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 0:12
 */
class ItemDropLogs extends LogsData
{

    public function getLogData($name = null)
    {
        $query = array('$and' => array(array('log-type' => 'item-drop-log'),array('content.user.player-name' => $name)));

        $cursor = $this->find(Collection::LOGS, $query);
        return $cursor;
    }


}