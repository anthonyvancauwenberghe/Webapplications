<?php
require_once('../libs/AutoLoader.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camera = new CameraData();
    $camera->processXMLRequest();
}
else {
    die();
}
