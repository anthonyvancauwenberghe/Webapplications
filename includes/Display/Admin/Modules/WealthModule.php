<?php
use MongoDB\Driver\Server;

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 18/09/2016
 * Time: 12:25
 */
class WealthModule
{
    private $GPWealth;
    private $DPWealth;

    public function setWealth()
    {
        $serverInfo = new ServerInfo();
        $wealth = $serverInfo->getCursor()->toArray();
        $this->setGPWealth($wealth);
        $this->setDPWealth($wealth);
    }

    private function setGPWealth($cursor)
    {
        $i = 0;
        $wealthArray = array();
        foreach ($cursor as $item) {
            $wealthArray[$i] = array(
                0 => ($this->convertToUnixTimestamp($item['time'])*1000),
                1 => ((int)($item['content']['coins'] / 1000000)));
            $i++;
        }
        $this->GPWealth = json_encode($wealthArray);
    }

    private function setDPWealth($cursor)
    {
        $i = 0;
        $wealthArray = array();
        foreach ($cursor as $item) {
            $wealthArray[$i] = array(

                0 => ($this->convertToUnixTimestamp($item['time'])*1000),
                1 => ((int)($item['content']['donator-points'] / 100)));
            $i++;
        }
        $this->DPWealth = json_encode($wealthArray);
    }

    public function getGPWealthData()
    {
        if (!isset($this->GPWealth)) {
            $this->setWealth();
        }
        return $this->GPWealth;
    }

    public function getDPWealthData()
    {
        if (!isset($this->DPWealth)) {
            $this->setWealth();
        }
        return $this->DPWealth;
    }

    public function convertToUnixTimestamp($time)
    {
        date_default_timezone_set('Europe/Brussels');
        $datetime = $time->toDateTime();
        $datetime = $datetime->format(DATE_RSS);

        return strtotime($datetime);
    }
}