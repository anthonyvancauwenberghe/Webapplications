<?php
require_once('../libs/AutoLoader.php');


class CameraData extends Data
{
    
    public function parseXML()
    {
        
            $postText = file_get_contents('php://input');
            $datetime = date('ymdHis');
            $xmlfile = "Camera" . $datetime . ".xml";
            $FileHandle = fopen($xmlfile, 'w') or die("can't open file");
            fwrite($FileHandle, $postText);
            fclose($FileHandle);


    }
}


?>