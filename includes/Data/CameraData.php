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

    private function insertDocument()
    {
        $document = array('data' => $this->getXML());
        $this->insertOne(Collection::CAMERAS, $document);
    }
    
    public function processXMLRequest(){
        $this->insertDocument();
    }
}


?>