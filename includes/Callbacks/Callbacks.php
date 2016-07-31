<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 4/07/2016
 * Time: 17:53
 */
class Callbacks
{
    private $data;
    private $core;

    protected function getData()
    {
        if (!isset($this->data)) {
            $this->data = new Data();
        }
        return $this->data;
    }
    
    protected function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }
}