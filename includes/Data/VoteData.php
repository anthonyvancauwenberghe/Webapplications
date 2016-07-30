<?php
require_once('../libs/AutoLoader.php');

class VoteData extends Data
{
    public function getVoteInfo($name)
    {
        $query = ['content.real-username'  => $name];
        $cursor = $this->find(Collection::VOTES, $query);

        return $cursor;
    }

    public function getVotecount($name)
    {
        $query = ['content.real-username' => $name];
        $cursor = $this->find(Collection::VOTES, $query);

        return count($cursor->toArray());
    }
    
}


?>