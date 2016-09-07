<?php

class TopG extends Voting
{
    public function processVote($input)
    {
        $this->extractData($input);
        $this->insertVote("TOPG");
    }
    
    
}