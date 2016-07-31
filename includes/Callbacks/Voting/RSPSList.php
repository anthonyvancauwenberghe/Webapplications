<?php
require_once('../libs/AutoLoader.php');

class RSPSList extends Voting
{
    public function processVote($input)
{
    $this->extractData($input);
    $this->insertVote("RSPSLIST");
}
}