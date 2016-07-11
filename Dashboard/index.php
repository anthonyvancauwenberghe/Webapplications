<?php

require_once '../libs/AutoLoader.php';

$core = new Core();
$core->setStartTime();


$serverData = new ServerData();
$generalData= new GeneralData();
var_dump($serverData->avgOnlineDayData());




echo $generalData->getIpLocation("84.28.124.122");
echo '<br>';



$core->setEndTime();
echo ' <br> Page generated in ' . $core->getPageLoadTime() . ' ms.';