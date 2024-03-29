<?php

class NPCData extends Data
{
    public function getNPCDropList()
    {


        $unwind = ['$unwind' => '$drops'];
        $group = ['$group' => ['_id' => ['name' => '$npcName', 'rarity' => '$drops.chance'], 'amount' => ['$sum' => 1]]];
        $group2 = ['$group' => ['_id' => '$_id.name', 'rarities' => ['$push' => ['rarity' => '$_id.rarity', 'amount' => '$amount']]]];

        $cursor = $this->aggregate(Collection::NPC_DROPS, [$unwind, $group, $group2]);

        $i = 0;
        $npcDropArray = array();
        foreach ($cursor as $npc) {

            $always = 0;
            $almost_always = 0;
            $very_common = 0;
            $common = 0;
            $uncommon = 0;
            $not_that_rare = 0;
            $rare = 0;
            $legendary = 0;
            $legendary2 = 0;
            $legendary3 = 0;
            $legendary4 = 0;
            $legendary5 = 0;

            foreach ($npc['rarities'] as $rarity) {
                if ($rarity['rarity'] == 'ALWAYS') {
                    $always = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'ALMOST_ALWAYS') {
                    $almost_always = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'VERY_COMMON') {
                    $very_common = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'COMMON') {
                    $common = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'UNCOMMON') {
                    $uncommon = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'NOT_THAT_RARE') {
                    $not_that_rare = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'RARE') {
                    $rare = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'LEGENDARY') {
                    $legendary = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'LEGENDARY_2') {
                    $legendary2 = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'LEGENDARY_3') {
                    $legendary3 = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'LEGENDARY_4') {
                    $legendary4 = $rarity['amount'];
                } elseif ($rarity['rarity'] == 'LEGENDARY_5') {
                    $legendary5 = $rarity['amount'];
                }

            }
            $amount = $always + $almost_always + $very_common + $common + $uncommon + $not_that_rare + $rare + $legendary + $legendary2 + $legendary3 + $legendary4 + $legendary5;
            $legendary_amount = $legendary + $legendary2 + $legendary3 + $legendary4 + $legendary5;
            $npcDropArray[$i] = array(
                'npcname' => ((string)$npc['_id']),
                'item-amount' => $amount,
                'always' => $always,
                'almost_always' => $almost_always,
                'very_common' => $very_common,
                'common' => $common,
                'uncommon' => $uncommon,
                'not_that_rare' => $not_that_rare,
                'rare' => $rare,
                'legendary' => $legendary_amount
            );

            $i++;
        }
        return $npcDropArray;


    }

    public function getNPCDrops($npc)
    {
        $npcName = (string)$npc;
        $pipeline = [['$match' => ['npcName' => $npcName]],
            ['$unwind' => '$drops'],
            ['$lookup' => [
                'from' => 'itemDefinition',
                'localField' => 'drops.item.itemId',
                'foreignField' => 'itemId',
                'as' => 'item'
            ]
            ],
            ['$unwind' => '$item'],
            ['$project' => ['_id' => '$drops.item.itemId', 'amount' => '$drops.item.amount', 'rarity' => '$drops.chance', 'item-name' => '$item.name', 'value' => ['$multiply' => ['$drops.item.amount', '$item.value']]]]];

        $cursor = $this->aggregate(Collection::NPC_DROPS, $pipeline);

        return $cursor;

    }
}