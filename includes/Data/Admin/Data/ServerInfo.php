<?php

class ServerInfo extends Admin
{
    public function getCursor()
    {
        $query = [['$match' => ['log-type' => 'server-wealth-log']], ['$sort' => ['time' => 1]]];
        $cursor = $this->aggregate(Collection::LOGS, $query);
        return $cursor;
    }

}