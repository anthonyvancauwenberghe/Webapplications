<?php

require_once('../libs/AutoLoader.php');

class Marketing
{
    private $core;

    private function getVisitorPreviousSite()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    private function getVisitorIp()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }

        return $ip;
    }

    private function getAdReffer()
    {
        if (!isset($_GET['ref'])) {
            return null;
        } else {
            return $this->getCore()->filterRequest($_GET['ref']);
        }
    }

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }

    private function checkDuplicateEntries($site, $ip, $type)
    {
        if($type=='ad'){
            return false;
        }
         
        if($type='ref'){
            return false;
        }

    }

    private function insertAdvertisementData()
    {

    }

    public function processMarketing()
    {
        $ip = $this->getVisitorIp();
        $adRef = $this->getAdReffer();
        $ref = $this->getAdReffer();

        if (isset($adRef)) {
            if (!$this->checkDuplicateEntries($adRef, $ip, 'ad')) {
                $this->insertAdvertisementData();
            }
        }

        if (isset($ref)) {
            if (!$this->checkDuplicateEntries($ref, $ip, 'ref')) {
            }
        }

    }
}