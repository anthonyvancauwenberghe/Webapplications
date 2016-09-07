<?php

class HiPay extends Donating
{
    public $code;
    public $message;

    private $parameters;

    private $ingame_name;
    private $order_id;
    private $SMSCode;
    private $profit;
    private $productName;
    private $country;
    private $amount;
    private $currency;
    private $orderDate;
    private $price;

    private function extractData()
    {
        $secretKey = 'c14dd20de7d0db42627fa3aae73d4c19';
        $core = $this->getCore();

        $this->parameters = $_GET;
        $signature = $this->parameters['api_sig'];
        unset($this->parameters['api_sig']);
        ksort($this->parameters);

        $string2compute = '';

        foreach ($this->parameters as $name => $value) {
            $string2compute .= $name . $value;
        }

        if (sha1($string2compute . $secretKey) == $signature) {
            $this->code = 0;
            $this->message = 'OK';
        } else {
            $this->code = 1;
            $this->message = 'KO';
        }

        $this->ingame_name = $this->parameters['user_id'];
        $this->ingame_name = strtr($this->ingame_name, array('+' => ' '));
        $this->ingame_name = $core->normalizeUsername($this->parameters['user_id']);

        $this->amount = $this->parameters['virtual_amount'];
        $this->amount = $this->amount / 100;

        $this->SMSCode = $this->parameters['code'];
        $this->order_id = $this->parameters['transaction_id'];
        $this->price = $this->parameters['paid'];
        $this->currency = $this->parameters['currency'];
        $this->country = $this->parameters['customer_country'];
        $this->productName = $this->parameters['product_name'];
        $this->profit = $this->parameters['payout_amount'];
        $this->orderDate = $this->parameters['date'];
    }


    private function insertDonation()
    {
        $data = $this->getData();

        $document = array("time" => new MongoDB\BSON\UTCDateTime(time() * 1000),

            "customer" => array(
                "country" => $this->country
            ),
            "purchase" => array(
                "order-id" => $this->order_id,
                "sms-code" => $this->SMSCode,
                "order-date" => new MongoDate(strtotime($this->orderDate)),
                "product-name" => $this->productName,
                "quantity" => 1,
                "price" => $this->price,
                "multiplier" => $this->getDonationMultiplier(),
                "profit" => $this->profit,
                "order-currency" => $this->currency,
                "payment-method" => "HIPAY"
            ),
            "game" => array(
                "player-name" => $this->ingame_name,
                "points-amount" => ($this->amount * $this->getDonationMultiplier()),
                "processed" => false
            )
        );

        $data->insertOne(Collection::DONATIONS, $document);
    }


    public function processDonation($input = null)
    {
        $this->extractData();

        if ($this->code == 0) {
            $this->insertDonation();
        }

    }
}