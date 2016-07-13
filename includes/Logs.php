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
        $i=1;
        foreach ($playerValuesArray as $key => $playerValue) {

            if(isset($playerValue)){
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

    public function getNPCSearchTerm(){
        if(isset($_GET['npc'])){
            return filter_var($_GET['npc'], FILTER_SANITIZE_STRING);
        }
        else{
            return 'ALL';
        }
    }
    public function getItemSearchTerm(){
        if(isset($_GET['item'])){
            return filter_var($_GET['item'], FILTER_SANITIZE_STRING);
        }
        else{
            return 'ALL';
        }
    }

    public function getNPCDrops()
    {
        if (!isset($this->NPCData)) {
            $this->NPCData = new NPCData();
        }

        if (isset($_GET['npc'])) {
            echo '<thead>
                        <tr>
                          <th>Drop ID</th>
                          <th>Drop Name</th>
                          <th>Drop Chance</th>
                          <th>Drop Amount</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

            for ($i = 1; $i < 5; $i++) {
                echo '<tr>';
                echo '<td>' . rand(0, 1000) . '</td>';
                echo '<td>Dragon Claws</td>';
                echo '<td>' . rand(0, 1000) / 1000 . '</td>';
                echo '<td>' . rand(0, 10) . '</td>';
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
            $npcDropArray = $this->NPCData->getNPCDrops();
            foreach ($npcDropArray as $npc) {
                if(isset($npc)) {
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

        if(isset($_GET['item'])){
            echo '<thead>
                        <tr>
                          <th>NPC ID</th>
                          <th>NPC Name</th>
                          <th>Drop Chance</th>
                          <th>Drop Amount</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

            for($i=1; $i<5; $i++) {
                echo '<tr>';
                echo '<td>' . rand(0,1000) . '</td>';
                echo '<td><a href="../drops.php?npc=bluedragon">Blue Dragon</a></td>';
                echo '<td>' . rand(0,10) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
        }
        else {
            echo '<thead>
                        <tr>
                          <th>Item ID</th>
                          <th>Item Name</th>
                          <th>Dropped by X NPCs</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

            for($i=1; $i<350; $i++) {
                echo '<tr>';
                echo '<td>' . rand(0,1000) . '</td>';
                echo '<td><a href="../drops.php?item=dragonclaws">Dragon Claws</a></td>';
                echo '<td>' . rand(0,10) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
        }



    }


}