<?php
require_once('../libs/AutoLoader.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camera = new CameraData();
    $camera->processXMLRequest();
}
else {
    die();
}
