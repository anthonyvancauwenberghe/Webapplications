<?php
require_once('../libs/AutoLoader.php');

class TopG implements voting
{
    private $ingame_name;

    public function insertVote()
    {
        $data = new Data();

        $document = array("time" => new MongoDB\BSON\UTCDateTime(time() * 1000),
            "processed" => false,
            "content" => array(
                "real-username" => $this->ingame_name,
                "fake-username" => $this->ingame_name,
                "website" => 'TOPG'
            ));

        $data->insertOne(Collection::VOTES, $document);
    }

    public function processVote($input)
    {
        $this->extractData($input);
        $this->insertVote();
    }

    private function extractData($input)
    {
        $core = new Core();
        $this->ingame_name = $core->normalizeUsername($input);
    }
}