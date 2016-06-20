<?php
require_once '../libs/AutoLoader.php';

class GeneralData extends Data
{
    public function getIpLocation($ip)
    {

        $filter = ['ip-address' => $ip];
        $cursor = $this->find('ipCollection', $filter);

        foreach($cursor as $document){
            $countryCode=$document['country-code'];
        }

        if ($countryCode == null) {
            $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);
            return $xml->geoplugin_countryCode->__toString();
            return null;
        } else {
            return $countryCode;
        }
    }
}


?>