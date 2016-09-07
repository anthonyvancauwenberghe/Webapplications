<?php

class VotesDisplay
{
    private $voteData;
    private $core;

    public function printVoteTables($name)
    {
        $name=$this->getCore()->normalizeUsername($name);

        echo '<thead>
                        <tr>
                          <th>Time</th>
                          <th>Website</th>
                          <th>Voting points</th>
                          <th>Bonus multiplier</th>
                          <th>Received</th>
                        </tr>
                      </thead>
                      <tbody>';

        $cursor = $this->getVoteData()->getVoteInfo($name);

        foreach ($cursor as $vote) {
            echo '<tr>';
            echo '<td>' . $this->getCore()->convertToTimeWithFormat($vote['time']) . '</td>';
            echo '<td>' . ucfirst(strtolower($vote['content']['website'])) . '</td>';
            echo '<td>' . $this->getCore()->checkIfNull((isset($vote['content']['pointsAmount'])) ? $vote['content']['pointsAmount'] : 'Unknown') . '</td>';
            echo '<td>' . $this->getCore()->checkIfNull((isset($vote['content']['multiplier'])) ? $vote['content']['multiplier'] : 1) . 'x</td>';
            echo '<td>' . $this->getCore()->convertTrueFalseToString($vote['processed']). '</td>';
            echo '</tr>';
        }
        echo '</tbody>';

    }

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }

    private function getVoteData()
    {
        if (!isset($this->voteData)) {
            $this->voteData = new VoteData();
        }
        return $this->voteData;
    }

    public function printVotesAmount($name){
        $name=$this->getCore()->normalizeUsername($name);
        echo $this->getVoteData()->getVotecount($name);
    }
}