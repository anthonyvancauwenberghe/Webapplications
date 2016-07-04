<?php

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 4/07/2016
 * Time: 17:33
 */
class HiPay
{
    var $code;
    var $message;
    var $parameters;

    private function getData(){
        $this->parameters = $_GET;
        $signature = $this->parameters['api_sig'];
        unset($this->parameters['api_sig']);
        ksort($this->parameters);
        $secretKey = 'c14dd20de7d0db42627fa3aae73d4c19'; // renseignez ici votre Clé d’API secrète
        $string2compute = '';
        foreach ($this->parameters as $name => $value) {
            $string2compute .= $name . $value;
        }
// true si OK, false sinon
// si vous utilisez md5 au lieu de sha1 merci de le remplacer
        if (sha1($string2compute . $secretKey) == $signature) {
            $this->code = 0;
            $this->message = 'OK';
        }
        else {
            $this->code = 1;
            $this->message = 'KO';
        }
    }


   public function insertDonation(){
       $ingame_name = $this->parameters['user_id'];
       $ingame_name = strtr($ingame_name, array ('+' => ' '));
       $amount = $this->parameters['virtual_amount'];
       $amount = $amount/100;
       $order_id = $this->parameters['code'];

// setup database connection

       $sql="INSERT INTO donator (TOKEN_ID, name, amount, finished, passed, recklesspk, method) VALUES('".$order_id."', '".$ingame_name."', '".$amount."', 0, 1, 2, 'allopass')";
   }






}