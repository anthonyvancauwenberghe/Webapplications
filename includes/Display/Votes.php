<?php

class Votes
{
    private $voteData;
    private $core;

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }
    
    private function getVoteData(){
        if (!isset($this->voteData)) {
            $this->voteData = new VoteData();
        }
        return $this->voteData;
    }

    public function printVoteTables($name)
    {
        $name=$this->getCore()->normalizeUsername($name);

        echo '<thead>
                        <tr>
                          <th>Timestamp</th>
                          <th>Website</th>
                          <th>Vote Points</th>
                          <th>Bonus Multiplier</th>
                          <th>Received</th>
                        </tr>
                      </thead>
                      <tbody>';

        $cursor = $this->getVoteData()->getVoteInfo($name);

        foreach ($cursor as $vote) {
            echo '<tr>';
            echo '<td>' . $this->getCore()->convertToTime($vote['time']) . '</td>';
            echo '<td>' . $vote['content']['website'] . '</td>';
            echo '<td>' . $this->getCore()->checkIfNull((isset($vote['content']['pointsAmount'])) ? $vote['content']['pointsAmount'] : null) . '</td>';
            echo '<td>' . $this->getCore()->checkIfNull((isset($vote['content']['multiplier'])) ? $vote['content']['multiplier'] : null) . '</td>';
            echo '<td>' . $this->getCore()->convertTrueFalseToString($vote['processed']). '</td>';
            echo '</tr>';
        }
        echo '</tbody>';

    }

    
    public function printVotesAmount($name){
        $name=$this->getCore()->normalizeUsername($name);
        echo $this->getVoteData()->getVotecount($name);
    }
}