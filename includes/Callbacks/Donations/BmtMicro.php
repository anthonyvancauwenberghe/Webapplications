<?php
require_once '../includes/Data.php';

class BmtMicro implements Donations
{
    
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

    public function insertDonation($bmtparser)
    {
        $core = new Core();
        $data = new Data();
        $ingame_name = ucfirst($bmtparser->getElement('orderparameters'));
        $ingame_name = $core->normalizeUsername($ingame_name);
        $order_id = (int)$bmtparser->getElement('orderid');
        $product_id = (int)$bmtparser->getElement('productid');
        $mail = $bmtparser->getElement('billing.email');
        $profit = (double)$bmtparser->getElement('vendorroyalty');
        $quantity = (int)$bmtparser->getElement('quantity');
        $productName = $bmtparser->getElement('productname');
        $ip = $bmtparser->getElement('ipaddress');
        $phone = $bmtparser->getElement('billing.phone');
        $country = $bmtparser->getElement('billing.country');
        $firstName = $bmtparser->getElement('billing.firstname');
        $lastName = $bmtparser->getElement('billing.lastname');
        $amount = $this->calculateAmount($product_id, $quantity);
        $currency = $bmtparser->getElement('ordercurrency');
        $orderDate = $bmtparser->getElement('orderdate');
        
        $document = array("time" => new MongoDate(),

            "customer" => array(
                "first-name" => $firstName,
                "last-name" => $lastName,
                "country" => $country,
                "mail-address" => $mail,
                "phone" => $phone,
                "ip-address" => $ip,
            ),
            "purchase" => array(
                "order-id" => $order_id,
                "order-date" => new MongoDate(strtotime($orderDate)),
                "product-name" => $productName,
                "product-id" => $product_id,
                "quantity" => $quantity,
                "profit" => $profit,
                "order-currency" => $currency,
                "payment-method" => "BMTMICRO"
            ),
            "game" => array(
                "player-name" => $ingame_name,
                "points-amount" => $amount,
                "processed" => false
            )
        );

        $data->insertOne(Collection::DONATIONS, $document);
    }


}