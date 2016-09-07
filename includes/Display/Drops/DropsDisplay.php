<?php

class DropsDisplay
{
    private $NPCData;
    

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

    public function printNPCDrops()
    {
        if (!isset($this->NPCData)) {
            $this->NPCData = new NPCData();
        }

        if (isset($_GET['npc'])) {
            echo '<thead>
                        <tr>
                          <th>Item ID</th>
                          <th>Item name</th>
                          <th>Item value</th>
                          <th>Drop amount</th>
                          <th>Drop rarity</th>
                          <th id="dropRarity" style="display: none"; >Drop rarity ID</th>
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
                echo '<td>' . ucfirst(strtolower(str_replace('_', ' ', $npcDrop['rarity']))) . '</td>';
                echo '<td style="display: none";>' . DropChance::convertRarityToId($npcDrop['rarity']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';

        } else {
            echo '<thead>
                        <tr>
                          <th>Npc name</th>
                          <th>Amount of items</th>
                          <th>Always</th>
                          <th>Almost always</th>
                          <th>Very Common</th>
                          <th>Common</th>
                          <th>Uncommon</th>
                          <th>Not that rare</th>
                          <th>Rare</th>
                          <th>Legendary</th>
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
                          <th>Npc ID</th>
                          <th>Npc name</th>
                          <th>Drop chance</th>
                          <th>Drop amount</th>
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