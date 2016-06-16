<?php

include '../includes/PlayerData.php';
include '../includes/Core.php';

$core=new Core();
$core->setStartTime();

$playerData=new PlayerData();
echo $playerData->getIpLocation("84.28.124.122");
echo '<br>';
echo $core->filterGETRequest('test');

$core->setEndTime();
echo ' <br> Page generated in '. $core->getLoadTime() .' ms.';