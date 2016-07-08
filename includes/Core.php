<?php

require_once('../libs/AutoLoader.php');

class Core
{
    protected static $startTime;
    protected static $endTime;
    private $config;
    private $data;

    public function convertToTime($time)
    {
        return date('h:i:s d-M-Y', $time->sec);
    }

    public function getDateof($timeUnit)
    {
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

    public function setStartTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$startTime = $time[1] + $time[0];
    }

    public function setEndTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$endTime = $time[1] + $time[0];
    }

    public function getPageLoadTime()
    {
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

    public function errorReporting()
    {
        if ($this->getConfig('Errors') == 'ON') {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        } else {

        }

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