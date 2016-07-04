<?php

require_once('../libs/AutoLoader.php');

$data = new Data();

$document = array("time" => new MongoDB\BSON\UTCDateTime(time() * 1000),

    "customer" => array(
        "country" => 'test'
    ));

$data->insertOne(Collection::DONATIONS, $document);