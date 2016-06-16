<?php
include 'Data.php';
class GeneralData extends Data
{
    public function getIpLocation($ip)
    {
        $country = $this->getIpCollection()->findOne(['ip-address' => $ip]);
        if ($country == null) {
            $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);
            return $xml->geoplugin_countryCode->__toString();
        } else {
            return $country['country-code'];
        }
    }
}


?>