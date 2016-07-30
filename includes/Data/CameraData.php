<?php
require_once('../libs/AutoLoader.php');


class CameraData extends Data
{

    private function getXML()
    {
        $postText = file_get_contents('php://input');
        return $postText;
    }

    private function buildDocument(){
        $xmldata = $this->getXML();
        $xml = simplexml_load_string($xmldata, 'SimpleXMLElement', LIBXML_NOCDATA) or die("Error: Cannot create object");
        $data = json_decode(json_encode((array)$xml), TRUE);
        $document = array('timestamp' => new MongoDB\BSON\UTCDateTime(time() * 1000), 'content'=>$data);
        return $document;
    }

    private function insertDocument()
    {
        $document = $this->buildDocument();
        $this->insertOne(Collection::CAMERAS, $document);
    }

    public function processXMLRequest()
    {
        $this->insertDocument();
    }
    
    public function getLicensePlateData(){
        $cursor = $this->find(Collection::CAMERAS, array());
        return $cursor;
    }
}


?>