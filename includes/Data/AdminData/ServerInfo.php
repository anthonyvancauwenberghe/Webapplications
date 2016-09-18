<?php

class ServerInfo extends AdminData
{
    public function getWealthCursor()
    {
        $query = [['$match' => ['log-type' => 'server-wealth-log']], ['$sort' => ['time' => 1]]];
        $cursor = $this->aggregate(Collection::LOGS, $query);
        return $cursor;
    }

}