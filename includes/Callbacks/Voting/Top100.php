<?php
require_once('../libs/AutoLoader.php');

class Top100 implements Voting
{
    private $ingame_name;

    public function processVote($input)
    {
        $this->extractData($input);
        $this->insertVote();

    }

    private function extractData($input){
        $this->ingame_name=$input;
    }

    private function insertVote()
    {
        $data = new Data();

        $document = array("time" => new MongoDate(),

            "customer" => array(
                "country" => $this->country
            ),
            "purchase" => array(
                "order-id" => $this->order_id,
                "sms-code" => $this->SMSCode,
                "order-date" => new MongoDate(strtotime($this->orderDate)),
                "product-name" => $this->productName,
                "quantity" => 1,
                "profit" => $this->profit,
                "order-currency" => $this->currency,
                "payment-method" => "HIPAY"
            ),
            "game" => array(
                "player-name" => $this->ingame_name,
                "points-amount" => $this->amount,
                "processed" => false
            )
        );

        $data->insertOne(Collection::VOTES, $document);
    }
}