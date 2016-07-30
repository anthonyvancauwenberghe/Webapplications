<?php
require_once('../libs/AutoLoader.php');


class CameraData extends Data
{
    
    public function parseXML()
    {
        
            $postText = file_get_contents('php://input');
            $datetime = $this->getCoreFunctions()->getTime();
            $xmlfile = "Camera" . $datetime . ".xml";
            file_put_contents($xmlfile, $postText);



    }
}


?>