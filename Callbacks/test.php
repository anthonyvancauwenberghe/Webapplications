<?php

require_once('../libs/AutoLoader.php');

$data = new Data();

$document = array("time" => new MongoDate(),

    "customer" => array(
        "country" => 'test'
    ));

$data->insertOne(Collection::DONATIONS, $document);