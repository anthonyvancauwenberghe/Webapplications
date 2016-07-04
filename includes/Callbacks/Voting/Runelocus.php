<?php
require_once('../libs/AutoLoader.php');

class Runelocus implements Voting
{
    private $ingame_name;

    public function insertVote()
    {
        // TODO: Implement processVote() method.
        echo "inserted vote succesfully for: " . $this->ingame_name;
    }

    public function processVote($input)
    {
        $this->extractData($input);
        $this->insertVote();
    }

    private function extractData($input)
    {
        $this->ingame_name = $input;
    }
}