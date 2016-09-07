<?php

require_once('../libs/AutoLoader.php');

class Core
{
    protected static $startTime;
    protected static $endTime;
    private $config;
    private $data;

    public function getTime()
    {
        $this->setTimezone();
        return date('ymdHis');
    }

    private function setTimezone()
    {
        date_default_timezone_set('Europe/Brussels');
    }

    public function convertTrueFalseToString($boolean)
    {
        if ($boolean) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function formatGP($gpValue)
    {
        if ($gpValue < 1000000) {
            return (string)round($gpValue / 1000, 2) . ' k';
        } elseif ($gpValue < 1000000000) {
            return (string)round($gpValue / 1000000, 2) . ' m';
        } else {
            return (string)round($gpValue / 1000000000, 2) . 'b';
        }
    }

    public function checkIfNull($input)
    {
        if (isset($input)) {
            return $input;
        } else {
            return '';
        }
    }

    public function convertToTime($time)
    {
        $this->setTimezone();
        $datetime = $time->toDateTime();
        $datetime = $datetime->format(DATE_RSS);

        return $datetime;

    }

    public function convertToTimeWithFormat($time, $format = DATE_RSS)
    {
        $this->setTimezone();
        $datetime = $time->toDateTime();
        $datetime = $datetime->format((string)$format);

        return $datetime;
    }

    public function convertToUnixTimestamp($time)
    {
        $this->setTimezone();
        $datetime = $time->toDateTime();
        $datetime = $datetime->format(DATE_RSS);

        return strtotime($datetime);
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

    public function getDayNumber()
    {
        date_default_timezone_set('Europe/Brussels');
        return (int)date("d", strtotime(date("Y-m-d")));
    }

    public function getWeekNumber()
    {
        date_default_timezone_set('Europe/Brussels');
        return (int)date("W", strtotime(date("Y-m-d")));
    }

    public function getMonthNumber()
    {
        date_default_timezone_set('Europe/Brussels');
        return (int)date("m", strtotime(date("Y-m-d")));
    }

    public function getYearNumber()
    {
        date_default_timezone_set('Europe/Brussels');
        return (int)date("Y", strtotime(date("Y-m-d")));
    }

    public function setStartTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$startTime = $time[1] + $time[0];
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

    private function setEndTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        self::$endTime = $time[1] + $time[0];
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