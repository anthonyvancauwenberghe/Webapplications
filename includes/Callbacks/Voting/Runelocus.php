<?php

class Runelocus extends Voting
{
    public function processVote($input)
    {
        $this->extractData($input);
        $this->insertVote("RUNELOCUS");
    }
    
}