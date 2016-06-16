<?php

require_once '../libs/AutoLoader.php';

$core = new Core();
$core->setStartTime();

$generalData = new GeneralData();
$donatorData = new DonatorData();
echo $donatorData->avgDonationsHourData();
echo '<br>';
echo $generalData->getIpLocation("84.28.124.122");


$core->setEndTime();
echo ' <br> Page generated in ' . $core->getPageLoadTime() . ' ms.';