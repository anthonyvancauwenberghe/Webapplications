<?php
require_once('../libs/AutoLoader.php');

class PlayerData extends Data
{
    public function getAccountvalues($username = null)
    {

        if (isset($username)) {
            $username = (string) $username;
            $match = ['$match' => ['log-type' => 'player-value-log', 'content.user.player-name' => $username]];
            $sort = ['$sort' => ['time' => -1]];
            $project = ['$project' => ['_id' => '$content.user.player-name', 'coins' => '$content.value.coins', 'donator-points' => '$content.value.donator-points']];

            $cursor = $this->aggregate(Collection::LOGS, [$match, $sort, $project]);
        } else {
            $match = ['$match' => ['log-type' => 'player-value-log']];
            $group = ['$group' => ['_id' => '$content.user.player-name',
                'coins' => ['$first' => '$content.value.coins'],
                'donator-points' => ['$first' => '$content.value.donator-points']]];
            $sort = ['$sort' => ['time' => -1]];


            $cursor = $this->aggregate(Collection::LOGS, [$match, $sort, $group]);

        }

        $i = 0;
        $playerArray = array();
        foreach ($cursor as $item) {

            $playerArray[$i] = array(

                'name' => ((string)$item['_id']),
                'gp' => ((int)(round($item['coins'] / 1000000, 2))),
                'dp' => ((int)(round($item['donator-points'] / 100, 2)))
            );

            $i++;
        }
        return json_encode($playerArray);


    }
}

