<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 8/09/2016
 * Time: 1:50
 */
class AccountValueLogs extends Data implements LogsData
{

    public function getLogData($username = null)
    {
        $weighting = 20000;

        if (isset($username)) {
            $username = (string)$username;
            $match = ['$match' => ['log-type' => 'player-value-log', 'content.user.player-name' => $username]];
            $sort = ['$sort' => ['time' => -1]];
            $project = ['$project' => ['_id' => '$content.user.player-name', 'coins' => '$content.value.coins', 'donator-points' => '$content.value.donator-points']];

            $cursor = $this->aggregate(Collection::LOGS, [$match, $sort, $project]);
        } else {

            $match = ['$match' => ['log-type' => 'player-value-log']];
            $sort = ['$sort' => ['time' => -1]];
            $group = ['$group' => ['_id' => '$content.user.player-name',
                'coins' => ['$first' => '$content.value.coins'],
                'donator-points' => ['$first' => '$content.value.donator-points']]];
            $project = ['$project' =>
                ['total-value' => ['$sum' => ['$coins', ['$multiply' => ['$donator-points', $weighting]]]],
                    'coins' => 1,
                    'donator-points' => 1]];
            $sort2 = ['$sort' => ['total-value' => -1]];

            $cursor = $this->aggregate(Collection::LOGS, [$match, $sort, $group, $project, $sort2]);

        }

        $i = 0;
        $playerValuesArray = array();
        foreach ($cursor as $item) {

            $playerValuesArray[$i] = array(

                'name' => ((string)$item['_id']),
                'gp' => (round((int)$item['coins'] / 1000000, 2)),
                'dp' => (round((int)$item['donator-points'] / 100, 2)),
                'accworth' => (round((int)$item['total-value'] / 1000000, 2))
            );

            $i++;
        }
        return $playerValuesArray;
    }

}