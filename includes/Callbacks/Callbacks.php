<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 4/07/2016
 * Time: 17:53
 */
class Callbacks extends Data
{
    private $core;
    
    protected function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }
}