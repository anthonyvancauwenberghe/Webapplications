<?php
require_once('../libs/AutoLoader.php');


class CameraData extends Data
{

    private function getXML()
    {

        $postText = file_get_contents('php://input');
        //$datetime = $this->getCoreFunctions()->getTime();
        //$xmlfile = "Camera" . $datetime . ".xml";
        //file_put_contents($xmlfile, $postText);
        return $postText;
    }

    private function buildDocument(){
        $xmlstr = $this->getXML();
        $xml = new SimpleXMLElement($xmlstr);
        $timestamp = $xml->Timestamp;
        $source = $xml->Source->Name;
        $plate = $xml->Object[0]->Value;
        $confidence = $xml->Object[0]->Confidence;
        $height = $xml->Snapshot[0]->Height;
        $width = $xml->Snapshot[0]->Width;
        $image = $xml->Snapshot[0]->Image;
        $document = array('timestamp' => $timestamp, 'data'=> $xmlstr,
            'content' => array('plate' => $plate, 'confidence' => $confidence, 'source' => $source,
                'image' => array('height' => $height, 'width' => $width, 'image' => $image)));

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
}


?>