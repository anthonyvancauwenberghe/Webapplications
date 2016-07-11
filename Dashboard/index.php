<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 22/06/2016
 * Time: 19:00
 */

require_once '../libs/AutoLoader.php';

$core = new Core();
$login = new LoginSystem();
$core->setStartTime();
$login->sec_session_start();
$login->processLogout();

if ($login->login_check()) {
    $logged = 'in';
    echo ' <br> Page generated in ' . $core->getPageLoadTime() . ' ms.';
} else {
    $logged = 'out';
    header("Location: ../login.php");
}

echo $logged;