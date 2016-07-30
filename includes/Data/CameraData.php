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
        $xmldata = $this->getXML();
        $xml = simplexml_load_string($xmldata, 'SimpleXMLElement', LIBXML_NOCDATA) or die("Error: Cannot create object");
        $data = json_decode(json_encode((array)$xml), TRUE);

        $timestamp = $data['AnalyticsEvent']['EventHeader']['Timestamp'];
        $source = $data['AnalyticsEvent']['EventHeader']['Source']['name'];
        $plate = $data['AnalyticsEvent']['ObjectList']['Object']['Value'];
        $confidence = $data['AnalyticsEvent']['ObjectList']['Object']['Confidence'];
        $height = $data['AnalyticsEvent']['SnapshotList']['Snapshot']['Height'];
        $width = $data['AnalyticsEvent']['SnapshotList']['Snapshot']['Width'];
        $image = $data['AnalyticsEvent']['SnapshotList']['Snapshot']['Image'];

        $document = array('timestamp' => $timestamp,
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