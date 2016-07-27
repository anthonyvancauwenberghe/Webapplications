<?php

class Donations
{
    private $donatorData;
    private $core;

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }
    
    private function getDonatorData(){
        if (!isset($this->donatorData)) {
            $this->donatorData = new DonatorData();
        }
        return $this->donatorData;
    }
    
    public function printDonationTables($name)
    {
        

        echo '<thead>
                        <tr>
                          <th>Order ID</th>
                          <th>Order Date</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Amount</th>
                          <th>Received</th>
                          <th>Payment Method</th>
                          <th>Mail</th>
                        </tr>
                      </thead>
                      <tbody>';

        $cursor = $this->getDonatorData()->getDonatorInfo($name);

        foreach ($cursor as $donation) {
            echo '<tr>';
            echo '<td>' . $donation['purchase']['order-id'] . '</td>';
            echo '<td>' . $this->getCore()->convertToTime($donation['purchase']['order-date']) . '</td>';
            echo '<td>' . $donation['purchase']['product-name'] . ' k</td>';
            echo '<td>' . $donation['purchase']['quantity'] . '</td>';
            echo '<td>' . $donation['game']['points-amount'] . '</td>';
            echo '<td>' . $donation['game']['processed'] . '</td>';
            echo '<td>' . $donation['purchase']['payment-method'] . '</td>';
            echo '<td>' . $donation['customer']['mail-address'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';

    }
    
    public function printDonationsAmount($name){
        echo $this->getDonatorData()->getAmountDonations($name);
    }
}