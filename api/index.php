<?php
require_once '../libs/AutoLoader.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['request'])){
	
	$core = new Core();
	$core->errorReporting();
	$playerData = new PlayerData();
	
	if($_GET['request']=="playercount"){
		echo $playerData->getPlayersOnline();
	}
	elseif($_GET['request']=="playercountbycountry"){
		echo $playerData->getPlayercountByCountry();
	}
	elseif($_GET['request']=="npcdroplist"){
		if(isset($_GET['npcname'])){
			echo $NPCData->getNpcDropList($_GET['npcname']);
		}
		else{
			echo "specify npc name";
		}
	}
	die();
}
else {
	die();
}
