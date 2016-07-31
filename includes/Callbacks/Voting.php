<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 4/07/2016
 * Time: 17:54
 */
abstract class Voting extends Callbacks
{
    private $name;

    abstract protected function processVote($input);

    protected function extractData($input)
    {
        $core = $this->getCore();
        $this->name = $core->normalizeUsername($input);
    }

    protected function insertVote($topList)
    {

        $document = array("time" => new MongoDB\BSON\UTCDateTime(time() * 1000),
            "processed" => false,
            "content" => array(
                "real-username" => $this->getName(),
                "fake-username" => $this->getName(),
                "website" => $topList,
                "pointsAmount" => round($this->getVotePoints($topList) * $this->getVoteMultiplier()),
                "multiplier" => $this->getVoteMultiplier()
            ));

        $this->getData()->insertOne(Collection::VOTES, $document);
    }

    private function getName()
    {
        return $this->name;
    }

    private function getVotePoints($topList)
    {
        $data = $this->getData()->findOne(Collection::CONFIG, ['config-type' => 'vote-points']);
        return $data['content'][$topList];
    }

    private function getVoteMultiplier()
    {
        $data = $this->getData()->findOne(Collection::CONFIG, ['config-type' => 'multipliers']);
        return $data['content']['vote'];
    }
}