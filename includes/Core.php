<?php

use MongoDB\BSON\UTCDatetime;

require_once('../libs/AutoLoader.php');

class Core
{
    protected static $startTime;
    protected static $endTime;
    private $config;

    private function setTimezone()
    {
        date_default_timezone_set('Europe/Brussels');
    }

    public function getTime()
    {
        $this->setTimezone();
        return date('ymdHis');
    }

    public function convertTrueFalseToString($boolean)
    {
        if ($boolean) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
    
    public function checkIfNull($input){
        if(isset($input)){
            return $input;
        }
        else{
            return '';
        }
    }

    public function convertToTime($time)
    {
        $this->setTimezone();
        $time = (string)$time;
        $time = round((int)($time) / 1000);
        return date('d-M-Y H:i:s ', (string)$time);
    }

    public function getDateof($timeUnit)
    {
        date_default_timezone_set('Europe/Brussels');
        $now = new \DateTime('now');
        $hour = $now->format('h');
        $day = $now->format('d');
        $month = $now->format('m');
        $year = $now->format('Y');

        if ($timeUnit == 'h') {
            return (int)$hour;
        } elseif ($timeUnit == 'd') {
            return (int)$day;
        } elseif ($timeUnit == 'm') {
            return (int)$month;
        } elseif ($timeUnit == 'y') {
            return (int)$year;
        } else {
            return 0;
        }

    }

    public function getWeekNumber()
    {
        date_default_timezone_set('Europe/Brussels');
        return date("W", strtotime(date("Y-m-d")));

    }

    public function setStartTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$startTime = $time[1] + $time[0];
    }

    private function setEndTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$endTime = $time[1] + $time[0];
    }

    public function getPageLoadTime()
    {
        $this->setEndTime();
        if (isset(self::$startTime) && isset(self::$endTime)) {
            $loadTime = round(self::$endTime - self::$startTime, 6) * 1000;
        } else {
            $loadTime = null;
        }

        return $loadTime;
    }

    public function filterRequest($variable)
    {
        if (!isset($variable)) {
            return null;
        } else {
            return (string)$variable;
        }

    }

    public function setErrorReportingOn()
    {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
    }

    public function getConfig($configName = null)
    {
        if (!isset($this->config)) {
            $config = parse_ini_file('config.ini');
        }

        if (isset($configName)) {
            return $config[$configName];
        } else {
            return $config;
        }

    }

    function normalizeUsername($username)
    {
        $username = strtolower($username);
        $username = str_replace('_', ' ', $username);
        $username = ucwords($username);
        return (string)$username;
    }

}


?>