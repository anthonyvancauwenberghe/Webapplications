<?php


class Core
{
    protected static $startTime;
    protected static $endTime;

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

    public function filterGETRequest($variable)
    {
        if (isset($_GET[$variable])) {
            return (string)$_GET[$variable];
        } else {
            return null;
        }

    }

    public function filterPOSTRequest($variable)
    {
        if (isset($_POST[$variable])) {
            return (string)$_POST[$variable];
        } else {
            return null;
        }
    }
}


?>