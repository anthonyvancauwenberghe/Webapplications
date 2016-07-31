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
        $name=$this->getCore()->normalizeUsername($name);

        echo '<thead>
                        <tr>
                          <th>Order ID</th>
                          <th>Order Date</th>
                          <th>Product Name</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>Points</th>
                          <th>Received</th>
                          <th>Payment Method</th>
                        </tr>
                      </thead>
                      <tbody>';

        $cursor = $this->getDonatorData()->getDonatorInfo($name);

        foreach ($cursor as $donation) {
            echo '<tr>';
            echo '<td>' . $donation['purchase']['order-id'] . '</td>';
            echo '<td>' . $this->getCore()->convertToTime($donation['purchase']['order-date']) . '</td>';
            echo '<td>' . $donation['purchase']['product-name'] . '</td>';
            echo '<td>' . $donation['game']['points-amount']/100 . ' $</td>';
            echo '<td>' . $donation['purchase']['quantity'] . '</td>';
            echo '<td>' . $donation['game']['points-amount'] . ' DP</td>';
            echo '<td>' . $this->getCore()->convertTrueFalseToString($donation['game']['processed']) . '</td>';
            echo '<td>' . $donation['purchase']['payment-method'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';

    }
    
    public function printDonationsAmount($name){
        $name=$this->getCore()->normalizeUsername($name);
        echo $this->getDonatorData()->getAmountDonations($name);
    }
}