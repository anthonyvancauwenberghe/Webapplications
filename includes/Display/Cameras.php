<?php

class Cameras
{
    private $cameraData;
    private $core;

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }
    
    private function getCameraData(){
        if (!isset($this->cameraData)) {
            $this->cameraData = new CameraData();
        }
        return $this->cameraData;
    }

    public function printLPRHuurderTables()
    {
        echo '<thead>
                        <tr>
                          <th>ID</th>
                          <th>Timestamp In</th>
                          <th>Time in Parking</th>
                          <th>License Plate</th>
                          <th>Give Free Pass</th>
                        </tr>
                      </thead>
                      <tbody>';

        $cursor = $this->getCameraData()->getLicensePlateData();

        foreach ($cursor as $document) {
            echo '<tr>';
            echo '<td><a href="../cameras.php?image=' . $document['_id'] . '" target="_blank">' . $document['_id'] . '</a></td>';
            echo '<td>' . $this->getCore()->convertToTime($document['timestamp']) . '</td>';
            echo '<td>TODO</td>';
            echo '<td>' . $document['content']['ObjectList']['Object']['Value'] . '</td>';
            echo '<td><a href="#"><img src="https://tools.verifyemailaddress.io/img/icons/add-icon.png"></a></td>';
            echo '</tr>';
        }
        echo '</tbody>';

    }

    public function printLPRLogTables()
    {
        echo '<thead>
                        <tr>
                          <th>ID</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>License Plate</th>
                          <th>Accuracy</th>
                          <th>Source</th>
                          <th>Image Size</th>
                          <th>Give Free Pass</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>';

        $cursor = $this->getCameraData()->getLicensePlateData();

        foreach ($cursor as $document) {
            echo '<tr>';
            echo '<td><a href="../cameras.php?image=' . $document['_id'] . '" target="_blank">' . $document['_id'] . '</a></td>';
            echo '<td>' . $this->getCore()->convertToTime($document['timestamp']) . '</td>';
            echo '<td>' . $this->getCore()->convertToTime($document['timestamp']) . '</td>';
            echo '<td>' . $document['content']['ObjectList']['Object']['Value'] . '</td>';
            echo '<td>' . $document['content']['ObjectList']['Object']['Confidence']*100 . ' %</td>';
            echo '<td>' . $document['content']['EventHeader']['Source']['Name'] . '</td>';
            echo '<td>' . round($document['content']['SnapshotList']['Snapshot']['SizeInBytes']/(1024),2) . ' Kb</td>';
            echo '<td><a href="#"><img src="https://tools.verifyemailaddress.io/img/icons/add-icon.png"></a></td>';
            echo '<td><a href="../cameras.php?delete=' . $document['_id'] . '"><img src="http://findicons.com/files/icons/1617/circular/16/delete.png"></a></td>';
            
            echo '</tr>';
        }
        echo '</tbody>';

    }



    public function printLicensePlateImage(){
        if(isset($_GET['image'])){
            echo '<img src="data:image/png;base64,' . $this->getEncodedImage($_GET['image']) . '" />';
            die();
        }
    }
    public function deletePlateFromDB(){
        if(isset($_GET['delete'])){
            $this->getCameraData()->deletePlate($_GET['delete']);
            header('Location: ../cameras.php');
            die();
        }
    }
    private function getEncodedImage($id){
        $image = $this->getCameraData()->getLicensePlateImage($id);
        return $image;
    }
}