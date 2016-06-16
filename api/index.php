<?php
include '../includes/Data/PlayerData.php';
include '../includes/Core.php';
if (isset($_GET['request'])){
	
	$core = new Core();
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
