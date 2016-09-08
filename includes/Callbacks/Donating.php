<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 4/07/2016
 * Time: 17:53
 */
abstract class Donating extends Callbacks
{
    protected $data;

    abstract protected function processDonation($input);
    
    protected function getDonationMultiplier()
    {
        $data = $this->findOne(Collection::CONFIG, ['config-type' => 'multipliers']);
        return $data['content']['donation'];
    }
}