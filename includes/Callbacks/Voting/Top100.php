<?php

class Top100 extends Voting
{
    public function processVote($input)
    {
        $this->extractData($input);
        $this->insertVote("TOP100");
    }
    
    
}