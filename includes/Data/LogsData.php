<?php

abstract class LogsData extends Data {
    abstract public function getLogData($input=null);

    public function getLogDataByID($id)
    {
        $query = array('$and' => array(array('_id'  => new MongoDB\BSON\ObjectId($id))));

        $cursor = $this->find(Collection::LOGS, $query);
        return $cursor;
    }
}

