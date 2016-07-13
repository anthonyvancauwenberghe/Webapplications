<?php

require_once '../libs/AutoLoader.php';

class Logs
{
    private $playerData;
    private $NPCData;

    public function getAccountvalues($username = null)
    {
        if (!isset($this->playerData)) {
            $this->playerData = new PlayerData();
        }

        $playerValuesArray = $this->playerData->getAccountvalues();
        echo '<thead>
                        <tr>
                          <th>Rank</th>
                          <th>Playername</th>
                          <th>GP Value (Mil)</th>
                          <th>DP Value ($)</th>
                          <th>Weighted Acc Value</th>
                        </tr>
                      </thead>
                      
                      <tbody>';
        $i = 1;
        foreach ($playerValuesArray as $key => $playerValue) {

            if (isset($playerValue)) {
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $playerValue["name"] . '</td>';
                echo '<td>' . $playerValue["gp"] . '</td>';
                echo '<td>' . $playerValue["dp"] . '</td>';
                echo '<td>' . $playerValue["accworth"] . '</td>';
                echo '</tr>';
            }
            $i++;
        }
        echo '</tbody>';

    }

    public function getNPCSearchTerm()
    {
        if (isset($_GET['npc'])) {
            return filter_var($_GET['npc'], FILTER_SANITIZE_STRING);
        } else {
            return 'ALL';
        }
    }

    public function getItemSearchTerm()
    {
        if (isset($_GET['item'])) {
            return filter_var($_GET['item'], FILTER_SANITIZE_STRING);
        } else {
            return 'ALL';
        }
    }

    private function convertRaritytoID($rarity)
    {
        $rarity = (string) $rarity;

        if ($rarity == 'ALWAYS') {
            $rarityid = 0;
        } elseif ($rarity == 'ALMOST_ALWAYS') {
            $rarityid = 1;
        } elseif ($rarity == 'VERY_COMMON') {
            $rarityid = 2;
        } elseif ($rarity == 'COMMON') {
            $rarityid = 3;
        } elseif ($rarity == 'UNCOMMON') {
            $rarityid = 4;
        } elseif ($rarity == 'NOT_THAT_RARE') {
            $rarityid = 5;
        } elseif ($rarity == 'RARE') {
            $rarityid = 6;
        } elseif ($rarity == 'LEGENDARY') {
            $rarityid = 7;
        } elseif ($rarity == 'LEGENDARY_2') {
            $rarityid = 8;
        } elseif ($rarity == 'LEGENDARY_3') {
            $rarityid = 9;
        } elseif ($rarity == 'LEGENDARY_4') {
            $rarityid = 10;
        } elseif ($rarity == 'LEGENDARY_5') {
            $rarityid = 11;
        }
        return $rarityid;
    }

    public function getNPCDrops()
    {
        if (!isset($this->NPCData)) {
            $this->NPCData = new NPCData();
        }

        if (isset($_GET['npc'])) {
            echo '<thead>
                        <tr>
                          <th>Item ID</th>
                          <th>Item Name</th>
                          <th>Item value</th>
                          <th>Drop Amount</th>
                          <th>Drop Rarity</th>
                          <th class="sorting_desc">Drop Rarity Id</th>
                        </tr>
                      </thead>
                      <tbody>';

            $cursor = $this->NPCData->getNPCDrops($_GET['npc']);

            foreach ($cursor as $npcDrop) {
                echo '<tr>';
                echo '<td>' . $npcDrop['_id'] . '</td>';
                echo '<td>' . $npcDrop['item-name'] . '</td>';
                echo '<td>' . round($npcDrop['value']/1000,2) . ' k</td>';
                echo '<td>' . $npcDrop['amount'] . '</td>';
                echo '<td>' . $npcDrop['rarity'] . '</td>';
                echo '<td>' . $this->convertRaritytoID($npcDrop['rarity']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';

        } else {
            echo '<thead>
                        <tr>
                          <th>NPC Name</th>
                          <th>Amount of Items</th>
                          <th>ALWAYS</th>
                          <th>ALMOST ALWAYS</th>
                          <th>VERY COMMON</th>
                          <th>COMMON</th>
                          <th>UNCOMMON</th>
                          <th>NOT THAT RARE</th>
                          <th>RARE</th>
                          <th>LEGENDARY</th>
                        </tr>
                      </thead>
                      
                      <tbody>';
            $npcDropArray = $this->NPCData->getNPCDropList();
            foreach ($npcDropArray as $npc) {
                if (isset($npc)) {
                    echo '<tr>';

                    echo '<td><a href="../drops.php?npc=' . $npc['npcname'] . '">' . $npc['npcname'] . '</a></td>';
                    echo '<td>' . $npc['item-amount'] . '</td>';
                    echo '<td>' . $npc['always'] . '</td>';
                    echo '<td>' . $npc['almost_always'] . '</td>';
                    echo '<td>' . $npc['very_common'] . '</td>';
                    echo '<td>' . $npc['common'] . '</td>';
                    echo '<td>' . $npc['uncommon'] . '</td>';
                    echo '<td>' . $npc['not_that_rare'] . '</td>';
                    echo '<td>' . $npc['rare'] . '</td>';
                    echo '<td>' . $npc['legendary'] . '</td>';
                    echo '</tr>';
                }

            }
            echo '</tbody>';
        }
    }

    public function getItemDrops()
    {
        if (!isset($this->NPCData)) {
            $this->NPCData = new NPCData();
        }

        if (isset($_GET['item'])) {
            echo '<thead>
                        <tr>
                          <th>NPC ID</th>
                          <th>NPC Name</th>
                          <th>Drop Chance</th>
                          <th>Drop Amount</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

            for ($i = 1; $i < 5; $i++) {
                echo '<tr>';
                echo '<td>' . rand(0, 1000) . '</td>';
                echo '<td><a href="../drops.php?npc=bluedragon">Blue Dragon</a></td>';
                echo '<td>' . rand(0, 10) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
        } else {
            echo '<thead>
                        <tr>
                          <th>Item ID</th>
                          <th>Item Name</th>
                          <th>Dropped by X NPCs</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

            for ($i = 1; $i < 350; $i++) {
                echo '<tr>';
                echo '<td>' . rand(0, 1000) . '</td>';
                echo '<td><a href="../drops.php?item=dragonclaws">Dragon Claws</a></td>';
                echo '<td>' . rand(0, 10) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
        }


    }


}