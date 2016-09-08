<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 1:05
 */
abstract class Input
{
    private $core;
    
    protected function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }
    
    protected function filterInput($input){
        return (string) $input;
    }

}