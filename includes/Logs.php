<?php

require_once '../libs/AutoLoader.php';

class Logs
{
    private $playerData;

    public function getAccountvalues($username = null)
    {
        if (!isset($this->playerData)) {
            $this->playerData = new PlayerData();
        }

        $playerValuesArray = $this->playerData->getAccountvalues();
        echo '<thead>
                        <tr>
                          <th>Playername</th>
                          <th>GP Value (Mil)</th>
                          <th>DP Value ($)</th>
                        </tr>
                      </thead>
                      <tbody>';
        
        foreach ($playerValuesArray as $key => $playerValue) {
            echo '<tr>';
            echo '<td>' . $playerValue["name"] . '</td>';
            echo '<td>' . $playerValue["gp"] . '</td>';
            echo '<td>' . $playerValue["dp"] . '</td>';
            echo '<tr>';
        }
        echo '</tbody>';

    }


}