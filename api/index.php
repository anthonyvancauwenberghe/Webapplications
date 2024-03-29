<?php
require_once('../libs/AutoLoader.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (isset($_GET['request'])) {

    $request = $_GET['request'];
    $object = new ObjectCreator();

    switch ($request) {

        case "playercount":
            echo $object->getServerData()->getPlayersOnline();
            break;

        case "playercountbycountry":
            echo $object->getServerData()->getPlayercountByCountry();
            break;

        case "objects":
            echo $object->getObjectsData()->getAllObjects();
            break;

        case "npcdroplist":
            if (isset($_GET['npcname'])) {
                echo $object->getNPCData()->getNPCDropList();
            } else {
                echo "specify npc name";
            }
            break;
        case "camera":
            break;
        

        default:
            break;
    }

    die();
}
else {
    die();
}
