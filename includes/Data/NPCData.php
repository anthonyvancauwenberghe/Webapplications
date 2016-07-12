<?php
require_once('../libs/AutoLoader.php');

class NPCData extends Data
{
    public function getNPCDrops($npc = null)
    {

        if (isset($npc)) {
            $npc = (string)$npc;

            $match = ['$match' => ['log-type' => 'player-value-log', 'content.user.player-name' => $npc]];
            $sort = ['$sort' => ['time' => -1]];
            $project = ['$project' => ['_id' => '$content.user.player-name', 'coins' => '$content.value.coins', 'donator-points' => '$content.value.donator-points']];

            $cursor = $this->aggregate(Collection::NPC_DROPS, [$match, $sort, $project]);
        } else {

            $match = ['$match' => ['log-type' => 'player-value-log']];
            $sort = ['$sort' => ['time' => -1]];
            $group = ['$group' => ['_id' => '$content.user.player-name',
                'coins' => ['$first' => '$content.value.coins'],
                'donator-points' => ['$first' => '$content.value.donator-points']]];


            $cursor = $this->aggregate(Collection::NPC_DROPS, [$match, $sort, $group, $sort2]);

        }

        $i = 0;
        $npcDropArray = array();
        foreach ($cursor as $item) {

            $npcDropArray[$i] = array(

                'name' => ((string)$item['_id']),
                'gp' => (round((int)$item['coins'] / 1000000, 2)),
                'dp' => (round((int)$item['donator-points'] / 100, 2)),
                'accworth' => (round((int)$item['total-value'] / 1000000, 2))
            );

            $i++;
        }
        return $npcDropArray;


    }
}

