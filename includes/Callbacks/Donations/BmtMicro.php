<?php

class BmtMicro extends Donating
{
    private $ingame_name;
    private $order_id;
    private $product_id;
    private $mail;
    private $profit;
    private $price;
    private $quantity;
    private $productName;
    private $ip;
    private $phone;
    private $country;
    private $firstName;
    private $lastName;
    private $amount;
    private $currency;
    private $orderDate;

    private function calculateAmount($productid, $quantity)
    {

        switch ($productid) {
            case 94700000:
                $amount = 1 * $quantity;
                break;
            case 94700001:
                $amount = 2 * $quantity;
                break;
            case 94700002:
                $amount = 5 * $quantity;
                break;
            case 94700003:
                $amount = 10 * $quantity;
                break;
            case 94700004:
                $amount = 20 * $quantity;
                break;
            case 94700005:
                $amount = 50 * $quantity;
                break;
            case 94700006:
                $amount = 100 * $quantity;
                break;
            default:
                $amount = 0;
                break;
        }
        
        $amount *= 100;

        return $amount;
    }

    private function extractData($bmtparser){
        $core = $this->getCore();

        $this->ingame_name = ucfirst($bmtparser->getElement('orderparameters'));
        $this->ingame_name = $core->normalizeUsername($this->ingame_name);
        $this->order_id = (int)$bmtparser->getElement('orderid');
        $this->product_id = (int)$bmtparser->getElement('productid');
        $this->mail = $bmtparser->getElement('billing.email');
        $this->profit = (double)$bmtparser->getElement('vendorroyalty');
        $this->quantity = (int)$bmtparser->getElement('quantity');
        $this->price = (double) $bmtparser->getElement ('productprice');
        $this->productName = $bmtparser->getElement('productname');
        $this->ip = $bmtparser->getElement('ipaddress');
        $this->phone = $bmtparser->getElement('billing.phone');
        $this->country = $bmtparser->getElement('billing.country');
        $this->firstName = $bmtparser->getElement('billing.firstname');
        $this->lastName = $bmtparser->getElement('billing.lastname');
        $this->amount = $this->calculateAmount($this->product_id, $this->quantity);
        $this->currency = $bmtparser->getElement('ordercurrency');
        $this->orderDate = $bmtparser->getElement('orderdate');
    }

    private function insertDonation()
    {
        

        $data = $this->getData();

        
        $document = array("time" => new MongoDB\BSON\UTCDateTime(time() * 1000),

            "customer" => array(
                "first-name" => $this->firstName,
                "last-name" => $this->lastName,
                "country" => $this->country,
                "mail-address" => $this->mail,
                "phone" => $this->phone,
                "ip-address" => $this->ip,
            ),
            "purchase" => array(
                "order-id" => $this->order_id,
                "order-date" => new MongoDB\BSON\UTCDateTime(strtotime($this->orderDate)*1000),
                "product-name" => $this->productName,
                "product-id" => $this->product_id,
                "quantity" => $this->quantity,
                "multiplier" => $this->getDonationMultiplier(),
                "profit" => $this->profit,
                "price" => $this->price,
                "order-currency" => $this->currency,
                "payment-method" => "BMTMICRO"
            ),
            "game" => array(
                "player-name" => $this->ingame_name,
                "points-amount" => round($this->amount*$this->getDonationMultiplier()),
                "processed" => false
            )
        );

        $data->insertOne(Collection::DONATIONS, $document);
    }
    
    public function processDonation($bmtparser){
        $this->extractData($bmtparser);
        $this->insertDonation();
    }


}