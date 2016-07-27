<?php
require_once('../libs/AutoLoader.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['request'])){
	$request = $_GET['request'];
	$core = new Core();
	$core->errorReporting();
	$playerData = new ServerData();
	$objectsData = new ObjectsData();
	
	
	switch($request){
		
		case "playercount":
			echo $playerData->getPlayersOnline();
			break;
		
		case "objects":
			echo $playerData->getPlayercountByCountry();
			break;
		
		case "playercountbycountry":
			echo $playerData->getPlayercountByCountry();
			break;
		
		case "npcdroplist":
			if(isset($_GET['npcname'])){
				echo $NPCData->getNpcDropList($_GET['npcname']);
			}
			else{
				echo "specify npc name";
			}
			break;
		
		default:
			break;
		
			
			

	}

	die();
}
