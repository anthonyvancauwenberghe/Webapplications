<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 1:14
 */
class LogsInput extends Input
{
    public function getLogType()
    {
        if (isset($_GET["logtype"])) {
            return $this->filterInput($_GET["logtype"]);
        } else {
            return null;
        }
    }
    
    public function getID(){
        if (isset($_GET["id"])) {
            return $this->filterInput($_GET["id"]);
        } else {
            return null;
        }
    }

    public function getName()
    {
        if (isset($_GET["name"])) {
            return $this->filterInput($this->getCore()->normalizeUsername($_GET["name"]));
        } else {
            return null;
        }
    }
}