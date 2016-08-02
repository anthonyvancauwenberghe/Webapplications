<?php
require_once('../libs/AutoLoader.php');


class CameraData extends Data
{

    private function getXML()
    {
        $postText = file_get_contents('php://input');
        return $postText;
    }

    private function buildDocument()
    {
        $xmldata = $this->getXML();
        $xml = simplexml_load_string($xmldata, 'SimpleXMLElement', LIBXML_NOCDATA) or die("Error: Cannot create object");
        $data = json_decode(json_encode((array)$xml), TRUE);
        $document = array('timestamp' => new MongoDB\BSON\UTCDateTime(time() * 1000), 'content' => $data);
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

    public function getLicensePlateData()
    {
        $cursor = $this->find(Collection::CAMERAS, array());
        return $cursor;
    }

    public function getLicensePlateImage($id)
    {
        $data = $this->findOne(Collection::CAMERAS, array('_id' => new MongoDB\BSON\ObjectID($id)));
        return $data['content']['SnapshotList']['Snapshot']['Image'];
    }
    
    public function deletePlate($id){
        $this->deleteOne(Collection::CAMERAS, array('_id' => new MongoDB\BSON\ObjectID($id)));
    }

    private function checkIfLicensePlateInParking($licensePlate, $ParkingPlates)
    {

        $input = $licensePlate;
        $words = $ParkingPlates;

        $shortest = -1;

        foreach ($words as $word) {

            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($input, $word);

            // check for an exact match
            if ($lev == 0) {

                // closest word is this one (exact match)
                $closest = $word;
                $shortest = 0;

                // break out of the loop; we've found an exact match
                break;
            }
            if ($lev == 1) {

                // closest word is this one (exact match)
                $closest = $word;
                $shortest = 1;

                // break out of the loop; we've found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest word has not yet been found
            if ($lev <= $shortest || $shortest < 0) {
                // set the closest match, and shortest distance
                $closest = $word;
                $shortest = $lev;

                if ($shortest >= 4) {
                    $closest = null;
                    $shortest = $lev;
                }

            }

        }
        return $closest;
    }

    public function ProcessPlateComparison(){

       $platesInParking = array('W1DEC8', 'A1818ATT', '1AOB136', '1DVM652', '1NET357', 'YTE846', '1A1111', 'VAH840');
        $licensePlate = '1GVM643';
        $mathchedPlate = $this->checkIfLicensePlateInParking($licensePlate, $platesInParking);
        echo 'Camera Scanned Plate: ' . $licensePlate;
        echo '<br>';
        echo 'Plates currently in parking: ';
        foreach($platesInParking as $plate){
            echo $plate.' ,';
        }
        echo '<br>';

        echo "MatchedPlate: ";
       echo isset($mathchedPlate) ? $mathchedPlate : "NONE FOUND";

    }
}


?>