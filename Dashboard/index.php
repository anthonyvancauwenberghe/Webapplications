<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 22/06/2016
 * Time: 19:00
 */

require_once '../libs/AutoLoader.php';

$core = new Core();
$core->setStartTime();
$login = new LoginSystem();
$login->sec_session_start();
$login->processLogout();
$login->processLoginCheck();


$logs = new Logs();
$serverData = new ServerData();
var_dump($logs->getAccountvalue());
//$serverData->avgOnlineHourData();


echo ' <br> Page generated in ' . $core->getPageLoadTime() . ' ms';

