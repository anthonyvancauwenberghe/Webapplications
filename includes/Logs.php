<?php

require_once '../libs/AutoLoader.php';

class Logs
{
 private $playerData;

    public function getAccountvalues($username = null)
    {
        if (!isset($this->playerData)) {
            $this->playerData = new playerData();
        }
        
                $accountValues = $this->playerData->getAccountvalues();

        echo '<thead>
                        <tr>
                          <th>player-name</th>
                          <th>GP Value (mil)</th>
                          <th>DP Value ($)</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                        <tr>
                          <td>Donna</td>
                          <td>Snider</td>
                          <td>Customer Support</td>
                          <td>New York</td>
                          <td>27</td>
                          <td>2011/01/25</td>
                          <td>$112,000</td>
                          <td>4226</td>
                          <td>d.snider@datatables.net</td>
                        </tr>
                      </tbody>';

    }

}