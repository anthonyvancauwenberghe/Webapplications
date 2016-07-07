<?php
require_once('../libs/AutoLoader.php');

if (isset($_GET['usr'])) {
    $runelocus = new Runelocus();
    $runelocus->processVote($_GET['usr']);
} elseif (isset($_POST['userid'])) {
    $rspslist = new RSPSList();
    $rspslist->processVote($_POST['userid']);
} elseif (isset($_GET['p_resp'])) {
    $topg = new TopG();
    $topg->processVote($_GET['p_resp']);
}
elseif (isset($_GET['postback'])) {
    $topg = new Top100();
    $topg->processVote($_GET['postback']);
}
else {
    die();
}