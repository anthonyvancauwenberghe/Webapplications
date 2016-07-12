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
                          <th>GPValue</th>
                          <th>DPValue</th>
                          <th>Office</th>
                          <th>Age</th>
                          <th>Startdate</th>
                          <th>Salary</th>
                          <th>Extn.</th>
                          <th>E-mail</th>
                        </tr>
                      </thead>
                      
                      <tbody>';
        foreach ($playerValuesArray as $key => $playerValue) {
            echo '<tr>';
            /*echo '<td>' . $playerValue["name"] . '</td>';
            echo '<td>' . $playerValue["gp"] . '</td>';
            echo '<td>' . $playerValue["dp"] . '</td>'; */
            echo'<td>New York</td>
                          <td>27</td>
                          <td>2011/01/25</td>
                          <td>$112,000</td>
                          <td>4226</td>
                          <td>d.snider@datatables.net</td>';
            echo '<tr>';
        }
        echo '</tbody>';

    }


}