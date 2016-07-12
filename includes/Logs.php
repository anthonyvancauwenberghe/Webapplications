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
    public function getNPCDrops($npc = null)
    {
        if (!isset($this->NPCData)) {
            $this->NPCData = new NPCData();
        }

        //$npcDropArray = $this->playerData->getAccountvalues();
        echo '<thead>
                        <tr>
                          <th>NPC Name</th>
                          <th>Amount of Items</th>
                          <th>NPC Drop Value</th>
                          <th>Drop</th>
                          <th>Drop/th>
                          <th>Drop</th>
                        </tr>
                      </thead>
                      
                      <tbody>';

        for($i=1; $i<100; $i++) {
            echo '<tr>';
            echo '<td>npc name '.$i.'</td>';
            echo '<td>' . rand(0,10) . '</td>';
            echo '<td>' . rand(0,1000) . '</td>';
            echo '<td>Dragon Claws</td>';
            echo '<td>Dragon Claws</td>';
            echo '<td>Dragon Claws</td>';
            echo '</tr>';

            /* if(isset($npcDropArray)){
                echo '<tr>';
                echo '<td>' . $npcDrop["name"] . '</td>';
                echo '<td>' . $npcDrop["gp"] . '</td>';
                echo '<td>' . $npcDrop["dp"] . '</td>';
                echo '</tr>';
            } */

        }
        echo '</tbody>';

    }


}