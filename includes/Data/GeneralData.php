<?php
require_once '../AutoLoadClasses.php';
/**
 * Class GeneralData
 */
class GeneralData extends Data
{
    /**
     * @param $ip
     * @return null
     */
    public function getIpLocation($ip)
    {

        $filter = ['ip-address' => $ip];
        
        $cursor = $this->find(Collection::IP_ADDRESSES, $filter);

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